<?php

/* index.html.twig */
class __TwigTemplate_bc9d78cb2d010f2e210d0b8cae5d6f75fb1fe8bfc72aedad62d91522b1005110 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );

        $this->macros = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
\t<head>
\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
\t<!-- Bootstrap -->
    <link href=\"/css/bootstrap.min.css\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"/css/sticky-footer.css\" rel=\"stylesheet\" media=\"screen\">
\t</head>
\t<body>
\t<div id=\"wrap\">

      <!-- Fixed navbar -->
      <div class=\"navbar navbar-fixed-top\">
        <div class=\"container\">
          <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".nav-collapse\">
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
          </button>
          <a class=\"navbar-brand\" href=\"#\">Evan Framework</a>
          <div class=\"nav-collapse collapse\">
            <ul class=\"nav navbar-nav\">
              <li class=\"active\"><a href=\"#\">Home</a></li>
              <li><a href=\"#about\">About</a></li>
              <li><a href=\"#contact\">Contact</a></li>
              <li class=\"dropdown\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Dropdown <b class=\"caret\"></b></a>
                <ul class=\"dropdown-menu\">
                  <li><a href=\"#\">Action</a></li>
                  <li><a href=\"#\">Another action</a></li>
                  <li><a href=\"#\">Something else here</a></li>
                  <li class=\"divider\"></li>
                  <li class=\"nav-header\">Nav header</li>
                  <li><a href=\"#\">Separated link</a></li>
                  <li><a href=\"#\">One more separated link</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>

      <!-- Begin page content -->
      <div class=\"container\">
        <div class=\"page-header\">
        \t";
        // line 46
        $this->displayBlock('content', $context, $blocks);
        // line 48
        echo "      </div>
    </div>
\t<div id=\"footer\">
      <div class=\"container\">
\t    <button type=\"button\" class=\"btn btn-success\" data-toggle=\"collapse\" data-target=\"#info\">
\t \tShow Information
\t\t</button>
      \t<div id=\"info\" class=\"collapse\">
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"span6\">
\t\t\t\t\t\t<table class=\"table\">
\t\t\t\t\t\t\t<tbody>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td>Method</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 62
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["request"]) ? $context["request"] : $this->getContext($context, "request")), "method"), "html", null, true);
        echo "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td>Uri</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 66
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["request"]) ? $context["request"] : $this->getContext($context, "request")), "uri"), "html", null, true);
        echo "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td>Browser Lang</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 70
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["request"]) ? $context["request"] : $this->getContext($context, "request")), "BrowserLang"), "html", null, true);
        echo "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td>Memory Usage</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 74
        echo twig_escape_filter($this->env, (isset($context["memory_usage"]) ? $context["memory_usage"] : $this->getContext($context, "memory_usage")), "html", null, true);
        echo "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td>Memory Peak</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 78
        echo twig_escape_filter($this->env, (isset($context["memory_peak"]) ? $context["memory_peak"] : $this->getContext($context, "memory_peak")), "html", null, true);
        echo "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td>Execution Time</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 82
        echo twig_escape_filter($this->env, (isset($context["execution_time"]) ? $context["execution_time"] : $this->getContext($context, "execution_time")), "html", null, true);
        echo "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t</tnody>
\t\t\t\t\t\t</table>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"span3 offset1\">
\t\t\t\t\t\t\t";
        // line 88
        if ((twig_length_filter($this->env, (isset($context["events_triggered"]) ? $context["events_triggered"] : $this->getContext($context, "events_triggered"))) > 0)) {
            // line 89
            echo "\t\t\t\t\t\t\t<h4>Events Triggered:</h4>
\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t";
            // line 91
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["events_triggered"]) ? $context["events_triggered"] : $this->getContext($context, "events_triggered")));
            foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                // line 92
                echo "\t\t\t\t\t\t\t\t\t<li>";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : $this->getContext($context, "event")), "alias"), "html", null, true);
                echo " called with ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : $this->getContext($context, "event")), "event"), "html", null, true);
                echo "</li>
\t\t\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['event'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 94
            echo "\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t";
        }
        // line 96
        echo "\t\t\t\t\t\t\t";
        if ((twig_length_filter($this->env, (isset($context["route_schema"]) ? $context["route_schema"] : $this->getContext($context, "route_schema"))) > 0)) {
            // line 97
            echo "\t\t\t\t\t\t\t<h4>Existing Routes</h4>
\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t";
            // line 99
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["route_schema"]) ? $context["route_schema"] : $this->getContext($context, "route_schema")));
            foreach ($context['_seq'] as $context["_key"] => $context["route"]) {
                // line 100
                echo "\t\t\t\t\t\t\t\t\t<li>route : ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["route"]) ? $context["route"] : $this->getContext($context, "route")), "route"), "html", null, true);
                echo "
\t\t\t\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t\t\t\t<li>Controller: \"";
                // line 102
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["route"]) ? $context["route"] : $this->getContext($context, "route")), "controller"), "html", null, true);
                echo "\"</li>
\t\t\t\t\t\t\t\t\t\t\t<li>Methods: \"";
                // line 103
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["route"]) ? $context["route"] : $this->getContext($context, "route")), "methods"), "html", null, true);
                echo "\"</li>
\t\t\t\t\t\t\t\t\t\t\t<li>Action: \"";
                // line 104
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["route"]) ? $context["route"] : $this->getContext($context, "route")), "action"), "html", null, true);
                echo "\"</li>
\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['route'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 108
            echo "\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t";
        }
        // line 110
        echo "\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
      </div>
    </div>
\t<script src=\"/js/jquery.js\"></script>
\t<script src=\"/js/bootstrap.min.js\"></script>
\t<script src=\"/js/respond.min.js\"></script>
\t</body>
</html>";
    }

    // line 46
    public function block_content($context, array $blocks = array())
    {
        // line 47
        echo "        \t";
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  212 => 47,  209 => 46,  196 => 110,  192 => 108,  182 => 104,  178 => 103,  174 => 102,  168 => 100,  164 => 99,  160 => 97,  157 => 96,  153 => 94,  142 => 92,  138 => 91,  134 => 89,  132 => 88,  123 => 82,  116 => 78,  109 => 74,  102 => 70,  95 => 66,  88 => 62,  72 => 48,  70 => 46,  23 => 1,  37 => 5,  34 => 4,  31 => 3,);
    }
}
