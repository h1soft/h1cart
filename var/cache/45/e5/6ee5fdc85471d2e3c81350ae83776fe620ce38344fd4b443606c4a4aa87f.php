<?php

/* admin/index.html */
class __TwigTemplate_45e56ee5fdc85471d2e3c81350ae83776fe620ce38344fd4b443606c4a4aa87f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("admin/layouts/admin.html");

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "admin/layouts/admin.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo "<div class=\"row \">
    <div class=\"large-12 columns\">
        <br/>
        <div class=\"panel\">
            <table class=\"large-12\"> 
                <thead>
                    <tr>
                        <th colspan=\"4\">系统信息</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>PHP版本</strong></td>
                        <td>";
        // line 16
        echo twig_escape_filter($this->env, (isset($context["PHP_VERSION"]) ? $context["PHP_VERSION"] : null), "html", null, true);
        echo "</td>
                        <td><strong>上传限制</strong></td>
                        <td>";
        // line 18
        echo twig_escape_filter($this->env, (isset($context["UPLOAD_MAX_FILESIZE"]) ? $context["UPLOAD_MAX_FILESIZE"] : null), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <td><strong>GD库</strong></td>
                        <td>";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["GD_INFO"]) ? $context["GD_INFO"] : null), "GD Version", array(), "array"), "html", null, true);
        echo "</td>
                        <td><strong>支持图片格式</strong></td>
                        <td>";
        // line 24
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["GD_IMGTYPE"]) ? $context["GD_IMGTYPE"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 25
            echo "                            ";
            echo twig_escape_filter($this->env, (isset($context["item"]) ? $context["item"] : null), "html", null, true);
            echo "
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "                        </td>
                    </tr>
                    <tr>
                        <td><strong>框架</strong></td>
                        <td>";
        // line 31
        echo twig_escape_filter($this->env, (isset($context["HVERSION"]) ? $context["HVERSION"] : null), "html", null, true);
        echo "</td>
                        <td><strong>MySQLI支持</strong></td>
                        <td>";
        // line 33
        echo (((isset($context["MYSQLI"]) ? $context["MYSQLI"] : null)) ? ("支持") : ("不支持"));
        echo "</td>
                    </tr>


                </tbody>
            </table>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "admin/index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 33,  82 => 31,  76 => 27,  67 => 25,  63 => 24,  58 => 22,  51 => 18,  46 => 16,  31 => 3,  28 => 2,);
    }
}
