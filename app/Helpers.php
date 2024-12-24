<?php

function getSidebarParent()
{
    $controller = request()->segment(1);
    $current_url = $controller ? substr($controller, 0, 1) : 'das';

    $filepath = public_path('group_access/' . session('group_id') . '.txt');

    if (file_exists($filepath)) {
        $filecontent = file_get_contents($filepath);
        $data = json_decode($filecontent, true);

        $result = '';
        if ($data) {
            foreach ($data as $row) {
                $active = $current_url == strtolower(substr($row['nama'], 0, 3)) ? 'active' : '';

                $result .= '<a href="#' . htmlspecialchars($row['link']) . '" class="nav-link ' . $active . '" data-toggle="tooltip-custom" data-placement="top" title="" data-original-title="' . htmlspecialchars($row['nama']) . '">' . PHP_EOL;
                $result .= '<i class="' . htmlspecialchars($row['icon']) . '"></i>' . PHP_EOL;
                $result .= '</a>' . PHP_EOL;
            }
        }
        return $result;
    } else {
        abort(404, 'File not found!');
    }
}

function getSidebarChild()
{
    $controller = request()->segment(1);
    $curr_url = $controller ? substr($controller, 0, 3) : 'das';

    $filepath = public_path('group_access/' . session('group_id') . '.txt');
    if (file_exists($filepath)) {
        $filecontent = file_get_contents($filepath);
        $data = json_decode($filecontent, true);

        $result = '';
        if ($data) {
            foreach ($data as $row) {
                $active = $curr_url == strtolower(substr($row['nama'], 0, 3)) ? 'active' : '';
                if (isset($row['sub']) && !empty($row['sub'])) {
                    $result .= '<div id="' . htmlspecialchars($row['link']) . '" class="main-icon-menu-pane ' . $active . '">' . PHP_EOL;
                    foreach ($row['sub'] as $subrow) {
                        $result .= '<div class="title-box">' . PHP_EOL;
                        $result .= '<h6 class="menu-title">' . htmlspecialchars($subrow['nama']) . '</h6>' . PHP_EOL;
                        $result .= '</div>' . PHP_EOL;

                        $result .= '<ul class="nav">' . PHP_EOL;
                        if (isset($subrow['child']) && !empty($subrow['child'])) {
                            foreach ($subrow['child'] as $childrow) {
                                $childactive = $controller == $childrow['link'] ? 'active' : '';

                                $result .= '<li class="nav-item"><a class="nav-link ' . $childactive . '" href="' . url(htmlspecialchars($childrow['link'])) . '"><i class="' . htmlspecialchars($childrow['icon']) . '"></i>' . htmlspecialchars($childrow['nama']) . '</a></li>' . PHP_EOL;
                            }
                        }
                        $result .= '</ul>' . PHP_EOL;
                    }
                    $result .= '</div>' . PHP_EOL;
                }
            }
        }
        return $result;
    } else {
        abort(404, 'Access not found');
    }
}
