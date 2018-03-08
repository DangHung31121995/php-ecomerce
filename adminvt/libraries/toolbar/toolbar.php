<?php
class ToolbarHelper
{
    var $title;
    var $buttons = array();
    var $buttons_html = array();
    function __construct()
    {
        $this->title = "Hệ thống quản lý nội dung(CMS)";
        $this->buttons = array();
        $this->buttons_html = array();
    }
    function addButton($task = 'task', $alt = 'task', $msg = '', $img = '', $validate = 0, $script = false)
    {
        $array = array(
            'task' => $task,
            'alt' => $alt,
            'msg' => $msg,
            'img' => $img,
            'validate' => $validate,
            'script' => $script);
        $buttons = isset($this->buttons) ? $this->buttons : array();
        $buttons[] = $array;
        $this->buttons = $buttons;
    }
    function addButtonHTML($html)
    {
        $buttons_html = isset($this->buttons_html) ? $this->buttons_html : array();
        $buttons_html[] = $html;
        $this->buttons_html = $buttons_html;
    }
    function show_head_form()
    {
        $html = "<div class=\"form_head\">";
        $html .= $this->showTitle();
        if (!empty($this->buttons) || !empty($this->buttons_html))
        {
            $html .= "<div id=\"wrap-toolbar\" class=\"wrap-toolbar\">";
            $html .= "  <div class=\"fr\">";
            $html .= $this->showButtons();
            $html .= "      <div class=\"clearfix\"></div>";
            $html .= "  </div>";
            $html .= "  <div class=\"clearfix\"></div>";
            $html .= "</div><!--end: .wrap-toolbar-->";
        }
        $html .= "</div><!--end: .form_head-->";
        $html .= $this->show_message();
        return $html;
    }
    function show_message()
    {
        $html = "";
        if (isset($_SESSION['have_redirect']))
        {
            if ($_SESSION['have_redirect'] == 1)
            {
                $html .= "<div id='message_rd' >";
                $types = array(
                    'error',
                    'alert',
                    'suc');
                foreach ($types as $type)
                {
                    if (isset($_SESSION["msg_$type"]))
                    {
                        $msg_error = $_SESSION["msg_$type"];
                        foreach ($msg_error as $item)
                        {
                            $html .= " 	<div class='message-content $type'>";
                            $html .= $item;
                            $html .= " </div>";
                        }
                        unset($_SESSION["msg_$type"]);
                    }
                }
                $html .= "</div>";
            }
            unset($_SESSION['have_redirect']);
        }
        return $html;
    }
    function setTitle($title = '', $icon = '')
    {
        $this->title = $title;
    }
    function showTitle()
    {
        $html = '<div class="content-title">
                    <div>
                        ' . $this->title . '
                    </div>
                </div><!--end: .content-title-->';
        return $html;
    }
    function showButtons()
    {
        $html = "";
        $buttons = $this->buttons;
        for ($i = 0; $i < count($buttons); $i++)
        {
            $item = $buttons[$i];
            if (!$item['validate'])
            {
                if ($item['msg'])
                {
                    if ($item['script'] == 1)
                    {
                        $html .= "<a class=\"toolbar " . $item['alt'] . "\" >";
                    } else
                    {
                        $html .= "<a class=\"toolbar\" onclick=\"javascript:if(document.adminForm.boxchecked.value==0){alert('" .
                            $item['msg'] . "');}else{  submitbutton('" . $item['task'] . "')} \" href=\"#\" >";
                    }
                    $html .= "<span title='" . $item['alt'] . "' style=\"background:url('templates/default/images/toolbar/" .
                        $item['img'] . "') no-repeat\" >";
                    $html .= "</span>";
                    $html .= $item['alt'];
                    $html .= "</a>";
                } else
                {
                    if ($item['script'] == 1)
                    {
                        $html .= "<a class=\"toolbar " . $item['alt'] . "\" >";
                    } else
                    {
                        $html .= "<a class=\"toolbar\" onclick=\"javascript: submitbutton('" . $item['task'] ."')\" href=\"#\" >";
                    }
                    $html .= "<span title='" . $item['alt'] . "' style=\"background:url('templates/default/images/toolbar/".$item['img'] . "') no-repeat\" >";
                    $html .= "</span>";
                    $html .= $item['alt'];
                    $html .= "</a>";
                }
            } else
            {
                if ($item['script'] == 1)
                {
                    $html .= "<a class=\"toolbar " . $item['alt'] . " \" >";
                } else
                {
                    $html .= "<a class=\"toolbar\" onclick=\"javascript:if(formValidator()){ submitbutton('" .
                        $item['task'] . "')} \" href=\"#\" >";
                }
                $html .= "<span title='" . $item['alt'] . "' style=\"background:url('templates/default/images/toolbar/" .
                    $item['img'] . "') no-repeat\" >";
                $html .= "</span>";
                $html .= $item['alt'];
                $html .= "</a>";
            }
        }
        $buttons_html = $this->buttons_html;
        if (count($buttons_html))
        {
            foreach ($buttons_html as $item)
            {
                $html .= $item;
            }
        }
        return $html;
    }
}
