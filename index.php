<?php
$demos = json_decode(file_get_contents('demos.json'));

function support($support) {
  $browsers = split(' ', 'ie firefox opera safari chrome'); // big 5 - should I add iPhone (for geo, etc)?

  $live = isset($support->live) ? split(' ', $support->live) : array();
  $nightly = isset($support->nightly) ? split(' ', $support->nightly) : array();
  
  $html = '';
  
  foreach ($browsers as $browser) {
    $class = '';
    if (in_array($browser, $live)) {
      $class .= ' live';
    } else if (in_array($browser, $nightly)) {
      $class .= ' nightly';
    } else {
      $class .= ' none';
    }
    
    $html .= '<span title="' . trim($class) . '" class="tag ' . $browser . $class . '">' . $browser . ':' . $class . '</span> ';
  }
  
  return $html;
}

function spans($list) {
  $items = split(' ', $list);
  $html = '';
  foreach ($items as $item) {
    $html .= '<span class="tag">' . $item . '</span> ';
  }
  
  return $html;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset=utf-8 />
<meta name="viewport" content="width=620" />
<title>yatil’s Lab</title>
<link rel="stylesheet" href="/css/html5demos.css" type="text/css" />
<script src="js/h5utils.js"></script>
</head>
<body>
<section id="wrapper">
    <header>
      <h1>yatil’s Lab:<br><abbr>HTML5</abbr> &amp; <abbr>CSS3</abbr><br>Demos and Examples</h1>
    </header>
    <article>

      <p id="tags" class="tags">
        
      </p>
      <table id="demos">
        <thead>
          <tr>
            <th>Demo</th>
            <th>Support</th>
            <th>Technology</th>            
          </tr>
        </thead>
        <tbody>
          <?php foreach ($demos as $demo) :?>
          <tr>
            <td class="demo"><a href="<?=$demo->url?>"><?=$demo->desc?></a><?php if (isset($demo->note)) { echo ' <small>' . $demo->note . '</small>'; }?></td>
            <td class="support"><?=support($demo->support)?></td>
            <td class="tags"><?=spans($demo->tags)?></td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
      
	<p>All content, code, video and audio is <a rel="license" href="http://creativecommons.org/licenses/by-sa/2.0/uk/">Creative Commons Share Alike 2.0</a></p>
    </article>
    <footer><p><a class="built" href="http://twitter.com/rem">@rem built this</a> &amp; <a class="built" href="http://twitter.com/yatil">@yatil forked it</a></p></footer> 
</section>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script>
$(document).delegate('span.tag', 'click', function () {
  var $tag = $(this), tag = $tag.text(), type = $tag.closest('td').attr('class') || 'tags';

  if ($tag.is('.selected')) {
    $('.' + type + ' span:contains(' + tag + ')').removeClass('selected');
  } else {
    $('.' + type + ' span:contains(' + tag + ')').addClass('selected');
  }

  // it's an AND filter
  var $trs = $('.' + type + ':has(span.selected)').closest('tr');
  if ($trs.length) {
    $('tbody tr').hide();
    $trs.show();
  } else {
    $('tbody tr').show();
  }  
});

var html = [];
$('.tags span.tag').each(function () {
  var $tag = $(this), tag = $tag.text();
  
  if (!tags[tag]) {
    tags[tag] = true;
    html.push('<span class="tag">' + tag + '</span> ');
  }
});

$('#tags').append('<strong>Filter demos:</strong> ' + html.sort().join(''));

// $('tr td.demo').click(function () {
//   window.location = $(this).find('a').attr('href');
// });

</script>
</body>
</html>
