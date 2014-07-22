<?php

/* admin/login.html */
class __TwigTemplate_77156a2cdd5679c76da812f487a601918ae29188fc37bbd6cde6520b6f5386da extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!doctype html>
<html class=\"no-js\" lang=\"en\">
    <head>
        <meta charset=\"utf-8\" />
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
        <title>H1Cart | Welcome</title>
        <link rel=\"stylesheet\" href=\"";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["BASEPATH"]) ? $context["BASEPATH"] : null), "html", null, true);
        echo "/themes/default/css/foundation.min.css\" />
        <link rel=\"stylesheet\" href=\"";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["BASEPATH"]) ? $context["BASEPATH"] : null), "html", null, true);
        echo "/themes/default/css/admin.css\" />
        <script src=\"";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["BASEPATH"]) ? $context["BASEPATH"] : null), "html", null, true);
        echo "/themes/default/js/vendor/modernizr.js\"></script>
    </head>
    <body>

        <div class=\"row\">
            <div class=\"large-12 columns text-center\">
                <h1>Welcome to H1Cart</h1>
            </div>
        </div>

        <div class=\"row \">
            <div class=\"large-12 columns\">
                <div class=\"panel small-3\">
                    <form role=\"form\" method=\"post\" action=\"\" >
                        <div class=\"row\">
                            <div class=\"large-12 columns\">
                                <label>用户名</label>
                                <input type=\"text\" placeholder=\"请输入用户名\" name=\"username\" type=\"username\" autofocus>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"large-12 columns\">
                                <label>密码</label>
                                <input type=\"password\" placeholder=\"请输入密码\"  name=\"password\">
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"large-12 columns margin-center text-right\">
                                <input class=\"success button\" type=\"submit\" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "admin/login.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 9,  31 => 8,  27 => 7,  19 => 1,);
    }
}
