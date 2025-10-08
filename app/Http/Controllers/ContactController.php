<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Строгая валидация телефона: +7 или 8, 11 цифр, допускаем пробелы, скобки и дефисы.
        $rules = [
            'name' => ['required', 'string', 'max:120'],
            'phone' => [
                'required',
                'string',
                'max:40',
                'regex:/^(?:\+7|8)[\s\-\(]?\d{3}[\)\s\-]*\d{3}[\s\-]*\d{2}[\s\-]*\d{2}$/'
            ],
            'date' => ['nullable', 'date', 'after_or_equal:today'],
        ];

        $messages = [
            'name.required' => 'Введите имя',
            'phone.required' => 'Укажите телефон',
            'phone.regex' => 'Телефон должен быть в формате +7 (XXX) XXX-XX-XX',
            'date.after_or_equal' => 'Дата не может быть раньше сегодняшней',
        ];
        // Кастомная валидация телефона: приводим к цифрам, проверяем 11 цифр и начало 7/8.
        $rules = [
            'name' => ['required', 'string', 'max:120'],
            'phone' => [
                'required',
                'string',
                'max:40',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/\D+/', '', $value ?? '');
                    if (strlen($digits) !== 11 || !in_array($digits[0], ['7', '8'])) {
                        return $fail('Телефон должен содержать 11 цифр и начинаться с +7 или 8.');
                    }
                }
            ],
            'date' => ['nullable', 'date', 'after_or_equal:today'],
        ];

        $messages = [
            'name.required' => 'Введите имя',
            'phone.required' => 'Укажите телефон',
            'date.after_or_equal' => 'Дата не может быть раньше сегодняшней',
        ];

        try {
            $validated = $request->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e; // стандартное поведение для non-AJAX
        }

        // Нормализуем телефон в digits-only формате для внутреннего использования
        $digits = preg_replace('/\D+/', '', $validated['phone']);
        if (str_starts_with($digits, '8')) {
            $digits = '7' . substr($digits, 1);
        }
        $validated['phone_normalized'] = $digits; // 7XXXXXXXXXX

        Log::info('Contact request', $validated);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Заявка отправлена. Мы свяжемся с вами.',
            ]);
        }

        return back()->with('contact_success', 'Заявка отправлена. Мы свяжемся с вами.');
    }
}
