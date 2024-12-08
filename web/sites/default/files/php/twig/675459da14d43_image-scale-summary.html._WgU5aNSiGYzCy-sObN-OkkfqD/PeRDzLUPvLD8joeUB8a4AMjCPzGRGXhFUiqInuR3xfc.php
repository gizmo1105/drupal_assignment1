<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* core/modules/image/templates/image-scale-summary.html.twig */
class __TwigTemplate_e73a3c2c6e35554539ac315344b0cb4a extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 19
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "width", [], "any", false, false, true, 19) && CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "height", [], "any", false, false, true, 19))) {
            // line 20
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "width", [], "any", false, false, true, 20), "html", null, true);
            yield "×";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "height", [], "any", false, false, true, 20), "html", null, true);
        } else {
            // line 22
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "width", [], "any", false, false, true, 22)) {
                // line 23
                yield "    ";
                yield t("width @data.width", array("@data.width" => CoreExtension::getAttribute($this->env, $this->source,                 // line 24
($context["data"] ?? null), "width", [], "any", false, false, true, 24), ));
                // line 26
                yield "  ";
            } elseif (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "height", [], "any", false, false, true, 26)) {
                // line 27
                yield "    ";
                yield t("height @data.height", array("@data.height" => CoreExtension::getAttribute($this->env, $this->source,                 // line 28
($context["data"] ?? null), "height", [], "any", false, false, true, 28), ));
                // line 30
                yield "  ";
            }
        }
        // line 32
        yield "
";
        // line 33
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "upscale", [], "any", false, false, true, 33)) {
            // line 34
            yield "  ";
            yield t("(upscaling allowed)", array());
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["data"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "core/modules/image/templates/image-scale-summary.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  73 => 34,  71 => 33,  68 => 32,  64 => 30,  62 => 28,  60 => 27,  57 => 26,  55 => 24,  53 => 23,  51 => 22,  46 => 20,  44 => 19,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "core/modules/image/templates/image-scale-summary.html.twig", "/var/www/html/web/core/modules/image/templates/image-scale-summary.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 19, "trans" => 23);
        static $filters = array("escape" => 20);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if', 'trans'],
                ['escape'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
