<?php

use PHPUnit\Framework\TestCase;

use function Pre\Phpx\Html\render;

class RenderTest extends TestCase
{
    public function test_can_render_html()
    {
        $actual = render("a", [
            "className" => [
                "link",
                function() {
                    return "lazy-link";
                },
            ],
            "style" => [
                "border" => "solid 1px #efefef",
                "font-weight" => function() {
                    return "bold";
                },
            ],
            "children" => [
                "left",
                " ",
                function() {
                    return "middle";
                },
                " ",
                "right",
            ],
        ]);

        $expected = "<a class=\"link lazy-link\" style=\"border: solid 1px #efefef; font-weight: bold;\">left middle right</a>";

        $this->assertEquals($expected, $actual, $actual);
    }
}
