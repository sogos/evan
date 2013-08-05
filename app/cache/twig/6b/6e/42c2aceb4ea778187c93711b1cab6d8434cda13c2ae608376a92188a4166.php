<?php

/* test.html.twig */
class __TwigTemplate_6b6e42c2aceb4ea778187c93711b1cab6d8434cda13c2ae608376a92188a4166 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("index.html.twig");

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );

        $this->macros = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "index.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "
Coucou ";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["toto"]) ? $context["toto"] : $this->getContext($context, "toto")), "html", null, true);
        echo "

";
    }

    public function getTemplateName()
    {
        return "test.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  37 => 5,  34 => 4,  31 => 3,);
    }
}
