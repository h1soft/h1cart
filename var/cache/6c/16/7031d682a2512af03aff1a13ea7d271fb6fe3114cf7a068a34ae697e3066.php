<?php

/* admin/layouts/admin.html */
class __TwigTemplate_6c167031d682a2512af03aff1a13ea7d271fb6fe3114cf7a068a34ae697e3066 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
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
        <title>";
        // line 6
        echo twig_escape_filter($this->env, (isset($context["pageTitle"]) ? $context["pageTitle"] : null), "html", null, true);
        echo " - H1Cart</title>
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
        echo "/themes/default/js/vendor/jquery.js\"></script>
        <script src=\"";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["BASEPATH"]) ? $context["BASEPATH"] : null), "html", null, true);
        echo "/themes/default/js/vendor/modernizr.js\"></script>        
        ";
        // line 11
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["cssFiles"]) ? $context["cssFiles"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["file"]) {
            // line 12
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["BASEPATH"]) ? $context["BASEPATH"] : null), "html", null, true);
            echo "/themes/";
            echo twig_escape_filter($this->env, (isset($context["file"]) ? $context["file"] : null), "html", null, true);
            echo "\" />
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['file'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo "        ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["jsFiles"]) ? $context["jsFiles"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["file"]) {
            // line 15
            echo "        <script src=\"";
            echo twig_escape_filter($this->env, (isset($context["BASEPATH"]) ? $context["BASEPATH"] : null), "html", null, true);
            echo "/themes/";
            echo twig_escape_filter($this->env, (isset($context["file"]) ? $context["file"] : null), "html", null, true);
            echo "\"></script>        
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['file'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "    </head>
    <body>
        <div class=\"fixed\">
            <nav class=\"top-bar\" data-topbar data-options=\"sticky_on: large\">
                <ul class=\"title-area\">
                    <li class=\"name\">
                        <h1><a href=\"";
        // line 23
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url_to')->getCallable(), array("index/index")), "html", null, true);
        echo "\">H1Cart</a></h1>
                    </li>
                    <!-- Remove the class \"menu-icon\" to get rid of menu icon. Take out \"Menu\" to just have icon alone -->
                    <li class=\"toggle-topbar menu-icon\"><a href=\"#\"><span>Menu</span></a></li>
                </ul>

                <section class=\"top-bar-section\">
                    <!-- Right Nav Section -->
                    <ul class=\"right\">
                        <li ><a href=\"";
        // line 32
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url_to')->getCallable(), array("index/logout")), "html", null, true);
        echo "\" class=\"button\">Logout</a></li>
                        <li class=\"has-dropdown\">
                            <a href=\"#\">Account</a>
                            <ul class=\"dropdown\">
                                <li><a href=\"";
        // line 36
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url_to')->getCallable(), array("account/setting")), "html", null, true);
        echo "\">Account Setting</a></li>
                                <li><a href=\"";
        // line 37
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url_to')->getCallable(), array("index/logout")), "html", null, true);
        echo "\">Logout</a></li>
                            </ul>
                        </li>                        
                    </ul>

                    <!-- Left Nav Section -->
                    <ul class=\"left\">
                        <li class=\"has-dropdown\">
                            <a href=\"#\">Catalog</a>
                            <ul class=\"dropdown\">
                                <li><a href=\"#\">Categories</a></li>
                                <li><a href=\"#\">Products</a></li>
                                <li class=\"has-dropdown\">
                                    <a href=\"#\">Attributes</a>
                                    <ul class=\"dropdown\">
                                        <li><a href=\"#\">Attributes</a></li>
                                        <li><a href=\"#\">Attribute Groups</a></li>
                                    </ul>
                                </li>
                                <li><a href=\"#\">Options</a></li>
                                <li><a href=\"#\">Manufacturer</a></li>
                                <li><a href=\"#\">Reviews</a></li>
                                <li><a href=\"#\">Pages</a></li>
                            </ul>
                        </li>
                        <li class=\"has-dropdown\">
                            <a href=\"#\">Extensions</a>
                            <ul class=\"dropdown\">
                                <li><a href=\"#\">Modules</a></li>
                                <li><a href=\"#\">Shipping</a></li>                              
                                <li><a href=\"#\">Payment</a></li>                              
                                <li><a href=\"#\">Order Totals</a></li>                              
                            </ul>
                        </li>                        
                        <li class=\"has-dropdown\">
                            <a href=\"#\">Sales</a>
                            <ul class=\"dropdown\">
                                <li><a href=\"#\">Orders</a></li>
                                <li class=\"has-dropdown\">
                                    <a href=\"#\">Customer</a>
                                    <ul class=\"dropdown\">
                                        <li><a href=\"#\">Customer</a></li>
                                        <li><a href=\"#\">Customer Groups</a></li>
                                    </ul>
                                </li>

                            </ul>
                        </li>
                        <li class=\"has-dropdown\">
                            <a href=\"#\">Reports</a>
                            <ul class=\"dropdown\">
                                <li class=\"has-dropdown\">
                                    <a href=\"#\">Sales</a>
                                    <ul class=\"dropdown\">
                                        <li><a href=\"#\">Orders</a></li>
                                    </ul>
                                </li>                                                                   
                            </ul>
                        </li>
                        <li class=\"has-dropdown\">
                            <a href=\"#\">System</a>
                            <ul class=\"dropdown\">
                                <li><a href=\"#\">Settings</a></li>                                
                                <li class=\"has-dropdown\">
                                    <a href=\"#\">Users</a>
                                    <ul class=\"dropdown\">
                                        <li><a href=\"#\">Users</a></li>
                                        <li><a href=\"#\">Customer Groups</a></li>
                                    </ul>
                                </li>
                                <li><a href=\"#\">Backup / Restore</a></li>                                                     
                            </ul>
                        </li>
                        <li><a href=\"http://www.h1cart.com\" target=\"_blank\">Help</a></li>
                    </ul>
                </section>
            </nav>
        </div>
        <ul class=\"breadcrumbs\">
            <li><a href=\"";
        // line 116
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('url_to')->getCallable(), array("index/index")), "html", null, true);
        echo "\">Home</a></li>                       
            ";
        // line 117
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["breadcrumbs"]) ? $context["breadcrumbs"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 118
            echo "            <li><a href=\"";
            echo twig_escape_filter($this->env, (isset($context["item"]) ? $context["item"] : null), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "name"), "html", null, true);
            echo "</a></li>                          
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 120
        echo "        </ul>
        <div class=\"row \">
            <div class=\"large-12 columns\">
                ";
        // line 123
        if (call_user_func_array($this->env->getFunction('flash')->getCallable(), array(false))) {
            echo "   
                <div class=\"row\">
                    <div class=\"large-12 columns\">
                        <div data-alert class=\"alert-box ";
            // line 126
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('flashCode')->getCallable(), array(false)), "html", null, true);
            echo " radius\">
                            ";
            // line 127
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('flash')->getCallable(), array()), "html", null, true);
            echo "
                            <a href=\"#\" class=\"close\">&times;</a>
                        </div>
                    </div>
                </div>               
                ";
        }
        // line 133
        echo "                <h3>";
        echo twig_escape_filter($this->env, (isset($context["pageTitle"]) ? $context["pageTitle"] : null), "html", null, true);
        echo "</h3>                
            </div>
        </div>
        ";
        // line 136
        $this->displayBlock('content', $context, $blocks);
        // line 137
        echo "
        <script src=\"";
        // line 138
        echo twig_escape_filter($this->env, (isset($context["BASEPATH"]) ? $context["BASEPATH"] : null), "html", null, true);
        echo "/themes/default/js/foundation.min.js\"></script>
        <script>
\$(document).foundation();
        </script>
    </body>
</html>
";
    }

    // line 136
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "admin/layouts/admin.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  257 => 136,  246 => 138,  243 => 137,  241 => 136,  234 => 133,  225 => 127,  221 => 126,  215 => 123,  210 => 120,  199 => 118,  195 => 117,  191 => 116,  109 => 37,  105 => 36,  98 => 32,  86 => 23,  78 => 17,  62 => 14,  47 => 11,  43 => 10,  39 => 9,  35 => 8,  27 => 6,  20 => 1,  87 => 33,  82 => 31,  76 => 27,  67 => 15,  63 => 24,  58 => 22,  51 => 12,  46 => 16,  31 => 7,  28 => 2,);
    }
}
