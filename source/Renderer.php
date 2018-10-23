<?php

namespace Pre\Phpx\Html;

use Exception;
use function Pre\Phpx\globalClassMatching;
use function Pre\Phpx\globalFunctionMatching;

class Renderer
{
    private $allowedTags = [
        // html
        "html",
        "head",
        "link",
        "meta",
        "base",
        "script",
        "style",
        "title",
        "body",
        "address",
        "article",
        "aside",
        "footer",
        "header",
        "h1",
        "h2",
        "h3",
        "h4",
        "h5",
        "h6",
        "hgroup",
        "nav",
        "section",
        "blockquote",
        "cite",
        "dd",
        "dt",
        "dl",
        "dir",
        "div",
        "figcaption",
        "figure",
        "hr",
        "li",
        "ol",
        "ul",
        "menu",
        "main",
        "p",
        "pre",
        "a",
        "abbr",
        "b",
        "bdi",
        "bdo",
        "br",
        "code",
        "data",
        "time",
        "dfn",
        "em",
        "i",
        "kbd",
        "mark",
        "q",
        "rp",
        "ruby",
        "rt",
        "rtc",
        "rb",
        "s",
        "del",
        "ins",
        "samp",
        "small",
        "span",
        "strong",
        "sub",
        "sup",
        "tt",
        "u",
        "var",
        "wbr",
        "area",
        "map",
        "audio",
        "source",
        "img",
        "track",
        "video",
        "applet",
        "object",
        "embed",
        "iframe",
        "noembed",
        "param",
        "picture",
        "canvas",
        "noscript",
        "caption",
        "table",
        "col",
        "colgroup",
        "tbody",
        "tr",
        "td",
        "tfoot",
        "th",
        "thead",
        "button",
        "datalist",
        "option",
        "fieldset",
        "label",
        "form",
        "input",
        "legend",
        "meter",
        "optgroup",
        "select",
        "output",
        "progress",
        "textarea",
        "details",
        "dialog",
        "menuitem",
        "summary",
        "content",
        "element",
        "shadow",
        "slot",
        "template",
        "acronym",
        "basefont",
        "bgsound",
        "big",
        "blink",
        "center",
        "command",
        "font",
        "frame",
        "frameset",
        "image",
        "isindex",
        "keygen",
        "listing",
        "marquee",
        "multicol",
        "nextid",
        "nobr",
        "noframes",
        "plaintext",
        "spacer",
        "strike",
        "xmp",

        // svg
        "a",
        "altGlyph",
        "altGlyphDef",
        "altGlyphItem",
        "animate",
        "animateColor",
        "animateMotion",
        "animateTransform",
        "circle",
        "clipPath",
        "color-profile",
        "cursor",
        "defs",
        "desc",
        "discard",
        "ellipse",
        "feBlend",
        "feColorMatrix",
        "feComponentTransfer",
        "feComposite",
        "feConvolveMatrix",
        "feDiffuseLighting",
        "feDisplacementMap",
        "feDistantLight",
        "feDropShadow",
        "feFlood",
        "feFuncA",
        "feFuncB",
        "feFuncG",
        "feFuncR",
        "feGaussianBlur",
        "feImage",
        "feMerge",
        "feMergeNode",
        "feMorphology",
        "feOffset",
        "fePointLight",
        "feSpecularLighting",
        "feSpotLight",
        "feTile",
        "feTurbulence",
        "filter",
        "font",
        "font-face",
        "font-face-format",
        "font-face-name",
        "font-face-src",
        "font-face-uri",
        "foreignObject",
        "g",
        "glyph",
        "glyphRef",
        "hatch",
        "hatchpath",
        "hkern",
        "image",
        "line",
        "linearGradient",
        "marker",
        "mask",
        "mesh",
        "meshgradient",
        "meshpatch",
        "meshrow",
        "metadata",
        "missing-glyph",
        "mpath",
        "path",
        "pattern",
        "polygon",
        "polyline",
        "radialGradient",
        "rect",
        "script",
        "set",
        "solidcolor",
        "stop",
        "style",
        "svg",
        "switch",
        "symbol",
        "text",
        "textPath",
        "title",
        "tref",
        "tspan",
        "unknown",
        "use",
        "view",
        "vkern",
    ];

    private $selfClosingTags = [
        "area",
        "base",
        "br",
        "col",
        "embed",
        "hr",
        "img",
        "input",
        "keygen",
        "link",
        "meta",
        "param",
        "source",
        "track",
        "wbr",
    ];

    private $renamedAttributes = [
        // html
        "accept-charset" => "acceptCharset",
        "accesskey" => "accessKey",
        "allowfullscreen" => "allowFullScreen",
        "autocapitalize" => "autoCapitalize",
        "autocomplete" => "autoComplete",
        "autocorrect" => "autoCorrect",
        "autofocus" => "autoFocus",
        "autoplay" => "autoPlay",
        "autosave" => "autoSave",
        "cellpadding" => "cellPadding",
        "cellspacing" => "cellSpacing",
        "charset" => "charSet",
        "classid" => "classID",
        "colspan" => "colSpan",
        "contenteditable" => "contentEditable",
        "contextmenu" => "contextMenu",
        "controlslist" => "controlsList",
        "crossorigin" => "crossOrigin",
        "datetime" => "dateTime",
        "defaultchecked" => "defaultChecked",
        "defaultvalue" => "defaultValue",
        "enctype" => "encType",
        "for" => "htmlFor",
        "formmethod" => "formMethod",
        "formaction" => "formAction",
        "formenctype" => "formEncType",
        "formnovalidate" => "formNoValidate",
        "formtarget" => "formTarget",
        "frameborder" => "frameBorder",
        "hreflang" => "hrefLang",
        "htmlfor" => "htmlFor",
        "http-equiv" => "httpEquiv",
        "innerhtml" => "innerHTML",
        "inputmode" => "inputMode",
        "itemid" => "itemID",
        "itemprop" => "itemProp",
        "itemref" => "itemRef",
        "itemscope" => "itemScope",
        "itemtype" => "itemType",
        "keyparams" => "keyParams",
        "keytype" => "keyType",
        "marginwidth" => "marginWidth",
        "marginheight" => "marginHeight",
        "maxlength" => "maxLength",
        "mediagroup" => "mediaGroup",
        "minlength" => "minLength",
        "nomodule" => "noModule",
        "novalidate" => "noValidate",
        "playsinline" => "playsInline",
        "radiogroup" => "radioGroup",
        "readonly" => "readOnly",
        "referrerpolicy" => "referrerPolicy",
        "rowspan" => "rowSpan",
        "spellcheck" => "spellCheck",
        "srcdoc" => "srcDoc",
        "srclang" => "srcLang",
        "srcset" => "srcSet",
        "tabindex" => "tabIndex",
        "usemap" => "useMap",

        // svg
        "accent-height" => "accentHeight",
        "alignment-baseline" => "alignmentBaseline",
        "allowreorder" => "allowReorder",
        "arabic-form" => "arabicForm",
        "attributename" => "attributeName",
        "attributetype" => "attributeType",
        "autoreverse" => "autoReverse",
        "basefrequency" => "baseFrequency",
        "baseline-shift" => "baselineShift",
        "baseprofile" => "baseProfile",
        "calcmode" => "calcMode",
        "cap-height" => "capHeight",
        "clip-path" => "clipPath",
        "clippathunits" => "clipPathUnits",
        "clip-rule" => "clipRule",
        "color-interpolation" => "colorInterpolation",
        "color-interpolation-filters" => "colorInterpolationFilters",
        "color-profile" => "colorProfile",
        "color-rendering" => "colorRendering",
        "contentscripttype" => "contentScriptType",
        "contentstyletype" => "contentStyleType",
        "diffuseconstant" => "diffuseConstant",
        "dominant-baseline" => "dominantBaseline",
        "edgemode" => "edgeMode",
        "enable-background" => "enableBackground",
        "externalresourcesrequired" => "externalResourcesRequired",
        "fill-opacity" => "fillOpacity",
        "fill-rule" => "fillRule",
        "filterres" => "filterRes",
        "filterunits" => "filterUnits",
        "flood-opacity" => "floodOpacity",
        "flood-color" => "floodColor",
        "font-family" => "fontFamily",
        "font-size" => "fontSize",
        "font-size-adjust" => "fontSizeAdjust",
        "font-stretch" => "fontStretch",
        "font-style" => "fontStyle",
        "font-variant" => "fontVariant",
        "font-weight" => "fontWeight",
        "glyph-name" => "glyphName",
        "glyph-orientation-horizontal" => "glyphOrientationHorizontal",
        "glyph-orientation-vertical" => "glyphOrientationVertical",
        "glyphref" => "glyphRef",
        "gradienttransform" => "gradientTransform",
        "gradientunits" => "gradientUnits",
        "horiz-adv-x" => "horizAdvX",
        "horiz-origin-x" => "horizOriginX",
        "image-rendering" => "imageRendering",
        "kernelmatrix" => "kernelMatrix",
        "kernelunitlength" => "kernelUnitLength",
        "keypoints" => "keyPoints",
        "keysplines" => "keySplines",
        "keytimes" => "keyTimes",
        "lengthadjust" => "lengthAdjust",
        "letter-spacing" => "letterSpacing",
        "lighting-color" => "lightingColor",
        "limitingconeangle" => "limitingConeAngle",
        "marker-end" => "markerEnd",
        "markerheight" => "markerHeight",
        "marker-mid" => "markerMid",
        "marker-start" => "markerStart",
        "markerunits" => "markerUnits",
        "markerwidth" => "markerWidth",
        "maskcontentunits" => "maskContentUnits",
        "maskunits" => "maskUnits",
        "numoctaves" => "numOctaves",
        "overline-position" => "overlinePosition",
        "overline-thickness" => "overlineThickness",
        "paint-order" => "paintOrder",
        "panose-1" => "panose1",
        "pathlength" => "pathLength",
        "patterncontentunits" => "patternContentUnits",
        "patterntransform" => "patternTransform",
        "patternunits" => "patternUnits",
        "pointer-events" => "pointerEvents",
        "pointsatx" => "pointsAtX",
        "pointsaty" => "pointsAtY",
        "pointsatz" => "pointsAtZ",
        "preservealpha" => "preserveAlpha",
        "preserveaspectratio" => "preserveAspectRatio",
        "primitiveunits" => "primitiveUnits",
        "refx" => "refX",
        "refy" => "refY",
        "rendering-intent" => "renderingIntent",
        "repeatcount" => "repeatCount",
        "repeatdur" => "repeatDur",
        "requiredextensions" => "requiredExtensions",
        "requiredfeatures" => "requiredFeatures",
        "shape-rendering" => "shapeRendering",
        "specularconstant" => "specularConstant",
        "specularexponent" => "specularExponent",
        "spreadmethod" => "spreadMethod",
        "startoffset" => "startOffset",
        "stddeviation" => "stdDeviation",
        "stitchtiles" => "stitchTiles",
        "stop-color" => "stopColor",
        "stop-opacity" => "stopOpacity",
        "strikethrough-position" => "strikethroughPosition",
        "strikethrough-thickness" => "strikethroughThickness",
        "stroke-dasharray" => "strokeDasharray",
        "stroke-dashoffset" => "strokeDashoffset",
        "stroke-linecap" => "strokeLinecap",
        "stroke-linejoin" => "strokeLinejoin",
        "stroke-miterlimit" => "strokeMiterlimit",
        "stroke-width" => "strokeWidth",
        "stroke-opacity" => "strokeOpacity",
        "suppresscontenteditablewarning" => "suppressContentEditableWarning",
        "suppresshydrationwarning" => "suppressHydrationWarning",
        "surfacescale" => "surfaceScale",
        "systemlanguage" => "systemLanguage",
        "tablevalues" => "tableValues",
        "targetx" => "targetX",
        "targety" => "targetY",
        "text-anchor" => "textAnchor",
        "text-decoration" => "textDecoration",
        "textlength" => "textLength",
        "text-rendering" => "textRendering",
        "underline-position" => "underlinePosition",
        "underline-thickness" => "underlineThickness",
        "unicode-bidi" => "unicodeBidi",
        "unicode-range" => "unicodeRange",
        "units-per-em" => "unitsPerEm",
        "v-alphabetic" => "vAlphabetic",
        "vector-effect" => "vectorEffect",
        "vert-adv-y" => "vertAdvY",
        "vert-origin-x" => "vertOriginX",
        "vert-origin-y" => "vertOriginY",
        "v-hanging" => "vHanging",
        "v-ideographic" => "vIdeographic",
        "viewbox" => "viewBox",
        "viewtarget" => "viewTarget",
        "v-mathematical" => "vMathematical",
        "word-spacing" => "wordSpacing",
        "writing-mode" => "writingMode",
        "xchannelselector" => "xChannelSelector",
        "x-height" => "xHeight",
        "xlink:actuate" => "xlinkActuate",
        "xlink:arcrole" => "xlinkArcrole",
        "xlink:href" => "xlinkHref",
        "xlink:role" => "xlinkRole",
        "xlink:show" => "xlinkShow",
        "xlink:title" => "xlinkTitle",
        "xlink:type" => "xlinkType",
        "xml:base" => "xmlBase",
        "xml:lang" => "xmlLang",
        "xml:space" => "xmlSpace",
        "xmlns:xlink" => "xmlnsXlink",
        "xmlspace" => "xmlSpace",
        "ychannelselector" => "yChannelSelector",
        "zoomandpan" => "zoomAndPan",
    ];

    private $ignoredFunctions = [
        "link",
    ];

    public function render($name, $props = null)
    {
        $props = $this->propsFrom($props);

        if (!in_array($name, $this->ignoredFunctions) && ($function = globalFunctionMatching($name))) {
            return call_user_func($function, $props);
        }

        if ($class = globalClassMatching($name)) {
            $instance = new $class($props);

            if (is_callable($instance)) {
                return $instance($props);
            }

            return $instance->render();
        }

        $className = $this->classNameFrom($props->className);
        unset($props->className);

        $style = $this->styleFrom($props->style);
        unset($props->style);

        $children = $this->childrenFrom($props->children);
        unset($props->children);

        $open = join(" ", array_filter([
            $name,
            $className,
            $style,
            $this->attributesFrom($props),
        ]));

        if (in_array($name, $this->selfClosingTags)) {
            return $this->format("<{$open} />");
        }

        return $this->format("<{$open}>{$children}</{$name}>");
    }

    public function propsFrom($props = null)
    {
        if (is_null($props)) {
            $props = (object) [];
        }

        if (is_array($props)) {
            $props = (object) $props;
        }

        if (!isset($props->children)) {
            $props->children = null;
        }

        if (!isset($props->className)) {
            $props->className = null;
        }

        if (!isset($props->style)) {
            $props->style = null;
        }

        return $props;
    }

    private function classNameFrom($className = null, $wrapped = true)
    {
        if (is_null($className)) {
            return null;
        }

        if (is_callable($className) && !is_string($className)) {
            $result = $this->classNameFrom($className(), false);
        }
    
        if (is_string($className)) {
            $result = $className;
        }

        if (is_array($className)) {
            $result = "";

            foreach ($className as $value) {
                $result .= $this->classNameFrom($value, false) . " ";
            }
        
            $result = trim($result);
        }

        if ($wrapped) {
            return "class=\"{$result}\"";
        }
    
        return $result;
    }

    private function styleFrom($style = null, $wrapped = true)
    {
        if (is_null($style)) {
            return null;
        }

        if (is_object($style)) {
            $style = (array) $style;
        }

        if (!is_array($style)) {
            throw new Exception("style must be an array or an object");
        }

        $result = "";

        foreach ($style as $key => $value) {
            if (is_callable($value)) {
                $value = $value();
            }

            $result .= "{$key}: {$value}; ";
        }
    
        $result = trim($result);

        if ($wrapped) {
            return "style=\"{$result}\"";
        }
    
        return $result;
    }

    private function childrenFrom($children = null)
    {
        if (is_array($children)) {
            return new Children($children);
        }

        return $children;
    }

    private function attributesFrom($props)
    {
        $attributes = [];

        foreach ($props as $key => $value) {
            $properKey = $key;

            if (isset($this->renamedAttributes[$key])) {
                $properKey = $this->renamedAttributes[$key];
            }

            $flippedAttributes = array_flip($reversedAttributes);

            if (isset($flippedAttributes[$properKey])) {
                $key = $flippedAttributes[$properKey];
            }

            if (is_callable($value)) {
                $value = $value();
            }

            if (is_array($value)) {
                $value = join(" ", $value);
            }

            $attributes[] = "{$key}=\"{$value}\"";
        }

        return join(" ", $attributes);
    }

    public function format($markup)
    {
        // left to avoid a version bump
        return $markup;
    }

    public function supports($name)
    {
        return in_array($name, $this->allowedTags);
    }
}
