<?php
/**
 * Rails Style html tag helpers
 *
 * These are used by the other examples to make the code
 * more concise and simpler to read.
 *
 * @copyright  Copyright (c) 2009-2013 Nicholas J Humfrey
 * @license    http://unlicense.org/
 */
/* Examples:
echo content_tag('p','Paragraph Tag', array('class'=>'foo'));
echo tag('br');
echo link_to2('Hyperlink', 'http://www.example.com/?a=1&b=2');
echo tag('br');
echo form_tag();
  echo label_tag('first_name').text_field_tag('first_name', 'Joe').tag('br');
  echo label_tag('password').password_field_tag().tag('br');
  echo label_tag('radio1_value1', 'Radio 1').radio_button_tag('radio1', 'value1').tag('br');
  echo label_tag('radio1_value2', 'Radio 2').radio_button_tag('radio1', 'value2', true).tag('br');
  echo label_tag('radio1_value3', 'Radio 3').radio_button_tag('radio1', 'value3').tag('br');
  echo label_tag('check1', 'Check 1').check_box_tag('check1', 'value1').tag('br');
  echo label_tag('check2', 'Check 2').check_box_tag('check2', 'value2', true).tag('br');
  echo label_tag('check3', 'Check 3').check_box_tag('check3', 'value3').tag('br');
  $options = array('Label 1' => 'value1', 'Label 2' => 'value2', 'Label 3' => 'value3');
  echo label_tag('select1', 'Select Something:');
  echo select_tag('select1', $options, 'value2').tag('br');
  echo label_tag('textarea1', 'Type Something:');
  echo text_area_tag('textarea1', "Hello World!").tag('br');
  echo submit_tag();
echo form_end_tag();
*/
function tag_options($options)
{
    $html = "";
    foreach ($options as $key => $value) {
        if ($key and $value) {
            $html .= " ".htmlspecialchars($key)."=\"".
                         htmlspecialchars($value)."\"";
        }
    }
    return $html;
}
function tag($name, $options = array(), $open = false)
{
    return "<$name".tag_options($options).($open ? ">" : " />");
}
function content_tag($name, $content = null, $options = array())
{
    return "<$name".tag_options($options).">".
           htmlspecialchars($content)."</$name>";
}
function link_to2($text, $uri = null, $options = array())
{
    if ($uri == null) $uri = $text;
    $options = array_merge(array('href' => $uri), $options);
    return content_tag('a', $text, $options);
}
function link_to2_self($text, $query_string, $options = array())
{
    return link_to2($text, $_SERVER['PHP_SELF'].'?'.$query_string, $options);
}
function image_tag($src, $options = array())
{
    $options = array_merge(array('src' => $src), $options);
    return tag('img', $options);
}
function input_tag($type, $name, $value = null, $options = array())
{
    $options = array_merge(
        array(
            'type' => $type,
            'name' => $name,
            'id' => $name,
            'value' => $value
        ),
        $options
    );
    return tag('input', $options);
}
function text_field_tag($name, $default = null, $options = array())
{
    $value = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
    return input_tag('text', $name, $value, $options);
}
function text_area_tag($name, $default = null, $options = array())
{
    $content = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
    $options = array_merge(
        array(
            'name' => $name,
            'id' => $name,
            'cols' => 60,
            'rows' => 5
        ),
        $options
    );
    return content_tag('textarea', $content, $options);
}
function hidden_field_tag($name, $default = null, $options = array())
{
    $value = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
    return input_tag('hidden', $name, $value, $options);
}
function password_field_tag($name = 'password', $default = null, $options = array())
{
    $value = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
    return input_tag('password', $name, $value, $options);
}
function radio_button_tag($name, $value, $default = false, $options = array())
{
    if ((isset($_REQUEST[$name]) and $_REQUEST[$name] == $value) or
        (!isset($_REQUEST[$name]) and $default))
    {
        $options = array_merge(array('checked' => 'checked'), $options);
    }
    $options = array_merge(array('id' => $name.'_'.$value), $options);
    return input_tag('radio', $name, $value, $options);
}
function check_box_tag($name, $value = '1', $default = false, $options = array())
{
    if ((isset($_REQUEST[$name]) and $_REQUEST[$name] == $value) or
        (!isset($_REQUEST['submit']) and $default))
    {
        $options = array_merge(array('checked' => 'checked'),$options);
    }
    return input_tag('checkbox', $name, $value, $options);
}
function submit_tag($name = '', $value = 'Submit', $options = array())
{
    return input_tag('submit', $name, $value, $options);
}
function reset_tag($name = '', $value = 'Reset', $options = array())
{
    return input_tag('reset', $name, $value, $options);
}
function label_tag($name, $text = null, $options = array())
{
    if ($text == null) {
        $text = ucwords(str_replace('_', ' ', $name)).': ';
    }
    $options = array_merge(
        array('for' => $name, 'id' => "label_for_$name"),
        $options
    );
    return content_tag('label', $text, $options);
}
function labeled_text_field_tag($name, $default = null, $options = array())
{
    return label_tag($name).text_field_tag($name, $default, $options);
}
function select_tag($name, $options, $default = null, $html_options = array())
{
    $opts = '';
    foreach ($options as $key => $value) {
        $arr = array('value' => $value);
        if ((isset($_REQUEST[$name]) and $_REQUEST[$name] == $value) or
            (!isset($_REQUEST[$name]) and $default == $value))
        {
            $arr = array_merge(array('selected' => 'selected'),$arr);
        }
        $opts .= content_tag('option', $key, $arr);
    }
    $html_options = array_merge(
        array('name' => $name, 'id' => $name),
        $html_options
    );
    return "<select".tag_options($html_options).">$opts</select>";
}
function form_tag($uri = null, $options = array())
{
    if ($uri == null) {
        $uri = $_SERVER['PHP_SELF'];
    }
    $options = array_merge(
        array('method' => 'get', 'action' => $uri),
        $options
    );
    return tag('form', $options, true);
}
function form_end_tag()
{
    return "</form>";
}
?>
<?php
    /**
     * Convert RDF from one format to another
     *
     * The source RDF data can either be fetched from the web
     * or typed into the Input box.
     *
     * The first thing that this script does is make a list the names of the
     * supported input and output formats. These options are then
     * displayed on the HTML form.
     *
     * The input data is loaded or parsed into an EasyRdf_Graph.
     * That graph is than outputted again in the desired output format.
     *
     * @package    EasyRdf
     * @copyright  Copyright (c) 2009-2013 Nicholas J Humfrey
     * @license    http://unlicense.org/
     */
    
    $input_format_options = array('Guess' => 'guess');
    $output_format_options = array();
    foreach (EasyRdf_Format::getFormats() as $format) {
        if ($format->getSerialiserClass()) {
            $output_format_options[$format->getLabel()] = $format->getName();
        }
        if ($format->getParserClass()) {
            $input_format_options[$format->getLabel()] = $format->getName();
        }
    }
    // Stupid PHP :(
    if (get_magic_quotes_gpc() and isset($_REQUEST['data'])) {
        $_REQUEST['data'] = stripslashes($_REQUEST['data']);
    }
    // Default to Guess input and Turtle output
    if (!isset($_REQUEST['output_format'])) {
        $_REQUEST['output_format'] = 'turtle';
    }
    if (!isset($_REQUEST['input_format'])) {
        $_REQUEST['input_format'] = 'guess';
    }
    // Display the form, if raw option isn't set
    if (!isset($_REQUEST['raw'])) {
        print "<html>\n";
        print "<head><title>EasyRdf Converter</title></head>\n";
        print "<body>\n";
        print "<h1>EasyRdf Converter</h1>\n";
        print "<div style='margin: 10px'>\n";
        print form_tag();
        print label_tag('data', 'Input Data: ').'<br />'.text_area_tag('data', '', array('cols'=>80, 'rows'=>10)) . "<br />\n";
        print label_tag('uri', 'or Uri: ').text_field_tag('uri', 'http://www.dajobe.org/foaf.rdf', array('size'=>80)) . "<br />\n";
        print label_tag('input_format', 'Input Format: ').select_tag('input_format', $input_format_options) . "<br />\n";
        print label_tag('output_format', 'Output Format: ').select_tag('output_format', $output_format_options) . "<br />\n";
        print label_tag('raw', 'Raw Output: ').check_box_tag('raw') . "<br />\n";
        print reset_tag() . submit_tag();
        print form_end_tag();
        print "</div>\n";
    }
    if (isset($_REQUEST['uri']) or isset($_REQUEST['data'])) {
        // Parse the input
        $graph = new EasyRdf_Graph($_REQUEST['uri']);
        if (empty($_REQUEST['data'])) {
            $graph->load($_REQUEST['uri'], $_REQUEST['input_format']);
        } else {
            $graph->parse($_REQUEST['data'], $_REQUEST['input_format'], $_REQUEST['uri']);
        }
        // Lookup the output format
        $format = EasyRdf_Format::getFormat($_REQUEST['output_format']);
        // Serialise to the new output format
        $output = $graph->serialise($format);
        if (!is_scalar($output)) {
            $output = var_export($output, true);
        }
        // Send the output back to the client
        if (isset($_REQUEST['raw'])) {
            header('Content-Type: '.$format->getDefaultMimeType());
            print $output;
        } else {
            print '<pre>'.htmlspecialchars($output).'</pre>';
        }
    }
    if (!isset($_REQUEST['raw'])) {
        print "</body>\n";
        print "</html>\n";
    }