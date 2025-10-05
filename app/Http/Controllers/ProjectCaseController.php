<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectCaseController extends Controller
{
    /**
     * Вернёт массив доступных кейсов (можно заменить на модель в будущем).
     * slug => data
     */
    protected function cases(): array
    {
        return [
            'galereya_vkusa' => [
                'title' => 'Галерея вкуса',
                'short' => 'Пекарня, кондитерская и кафе',
                'cover' => asset('images/our_projects/pekarnya/fasade_large.jpg'),
                // 'images' => [...] // можно не указывать — будут подобраны автоматически
            ],
            'nesk' => [
                'title' => 'НЭСК',
                'short' => 'Офис компании, занимающейся поставками электроэнергии',
                'cover' => asset('images/our_projects/nesk/1.jpg'),
            ],
            'dynasty' => [
                'title' => 'Династия',
                'short' => 'Ресторанно-гостиничный комплекс',
                'cover' => asset('images/our_projects/caplya/1.jpg'),
            ],
            'kfh' => [
                'title' => 'КФХ',
                'short' => 'Крестьянско-фермерское хозяйство',
                'cover' => asset('images/our_projects/kfh_loza/1.jpg'),
            ],
            'sosh_1' => [
                'title' => 'МАОУ СОШ № 1',
                'short' => 'Средняя общеобразовательная школа № 1 имени А. Ф. Крамаренко',
                'cover' => asset('images/our_projects/SOSH_1/СОШ_1.jpeg'),
            ],
            'shor_vvs' => [
                'title' => 'СШОР ВВС',
                'short' => 'Специальная школа олимпийского резерва ВВС',
                'cover' => asset('images/our_projects/shor_vodnyi/1.jpg'),
            ],
        ];
    }

    /**
     * Автоподбор изображений из папки public/images/our_projects/<slug>
     */
    protected function autoDiscoverImages(string $slug, array $case): array
    {
        // Если images явно заданы — уважаем их
        if (!empty($case['images']) && is_array($case['images'])) {
            return $case['images'];
        }
        $baseDir = public_path('images/our_projects/' . $this->slugToDir($slug));
        if (!is_dir($baseDir)) {
            return [];
        }
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
        $files = scandir($baseDir) ?: [];
        $result = [];
        foreach ($files as $f) {
            if ($f === '.' || $f === '..') continue;
            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed, true)) continue;
            $result[] = 'images/our_projects/' . $this->slugToDir($slug) . '/' . $f;
        }
        // Отсортируем по имени для предсказуемости
        sort($result, SORT_NATURAL | SORT_FLAG_CASE);
        return $result;
    }

    protected function slugToDir(string $slug): string
    {
        // Возможность маппинга если slug != папка, пока 1:1
        return match ($slug) {
            'galereya_vkusa' => 'pekarnya',
            'dynasty' => 'caplya',
            default => $slug,
        };
    }

    /**
     * Рыба описания (абзацы) если описание отсутствует
     */
    protected function placeholderDescription(array $case): array
    {
        return [
            'Данный проект представляет собой комплекс работ, выполненных нашей командой с соблюдением всех нормативных требований и внутренних стандартов качества.',
            'В процессе реализации особое внимание уделялось надёжности систем, удобству последующей эксплуатации и технике безопасности.',
            'Использованы современные материалы и технологии, что позволило оптимизировать сроки и снизить эксплуатационные затраты.',
            'Командное взаимодействие и прозрачная коммуникация с заказчиком обеспечили предсказуемость результатов на каждом этапе.',
            'Завершённый объект передан с комплектом исполнительной документации и рекомендациями по дальнейшему обслуживанию.'
        ];
    }

    /**
     * Страница со всеми проектами.
     */
    public function index(): View
    {
        $cases = $this->cases();
        return view('projects.main', compact('cases'));
    }

    /**
     * Показывает отдельный кейс.
     */
    public function show(string $slug): View
    {
        $cases = $this->cases();
        if (!array_key_exists($slug, $cases)) {
            throw new NotFoundHttpException();
        }
        $ordered = array_keys($cases);
        $index = array_search($slug, $ordered, true);
        $prevSlug = $ordered[$index - 1] ?? null;
        $nextSlug = $ordered[$index + 1] ?? null;

        $neighbors = [
            'prev' => $prevSlug ? ['slug' => $prevSlug, 'title' => $cases[$prevSlug]['title']] : null,
            'next' => $nextSlug ? ['slug' => $nextSlug, 'title' => $cases[$nextSlug]['title']] : null,
        ];

        $case = $cases[$slug];

        // Автоподбор изображений
        $images = $this->autoDiscoverImages($slug, $case);
        if (!empty($images)) {
            $case['images'] = $images;
        }

        // Если нет description / description_html — подставляем рыбу
        if (empty($case['description_html']) && empty($case['description'])) {
            $case['description'] = $this->placeholderDescription($case);
        }

        return view('projects.cases.show', compact('case', 'slug', 'neighbors'));
    }
}