<?php
/* SVN FILE: $Id: text.php 7172 2008-06-11 15:46:31Z gwoo $ */

/**
 * Text Helper
 *
 * Text manipulations: Highlight, excerpt, truncate, strip of links, convert email addresses to mailto: links...
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.cake.libs.view.helpers
 * @since			CakePHP(tm) v 0.10.0.1076
 * @version			$Revision: 7172 $
 * @modifiedby		$LastChangedBy: gwoo $
 * @lastmodified	$Date: 2008-06-11 10:46:31 -0500 (Wed, 11 Jun 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Included libraries.
 *
 */

if (!class_exists('HtmlHelper')) {
	App::import('Helper', 'Html');
}

/**
 * Text helper library.
 *
 * Text manipulations: Highlight, excerpt, truncate, strip of links, convert email addresses to mailto: links...
 *
 * @package		cake
 * @subpackage	cake.cake.libs.view.helpers
 */
class TextHelper extends AppHelper {

/**
 * Highlights a given phrase in a text. You can specify any expression in highlighter that
 * may include the \1 expression to include the $phrase found.
 *
 * @param string $text Text to search the phrase in
 * @param string $phrase The phrase that will be searched
 * @param string $highlighter The piece of html with that the phrase will be highlighted
 * @param boolean $considerHtml If true, will ignore any HTML tags, ensuring that only the correct text is highlighted
 * @return string The highlighted text
 * @access public
 */
	function highlight($text, $phrase, $highlighter = '<span class="highlight">\1</span>', $considerHtml = false) {
		if (empty($phrase)) {
			return $text;
		}

		if (is_array($phrase)) {
			$replace = array();
			$with = array();

			foreach ($phrase as $key => $value) {
				$key = $value;
				$value = $highlighter;
				$key = '(' . $key . ')';
				if ($considerHtml) {
					$key = '(?![^<]+>)' . $key . '(?![^<]+>)';
				}
				$replace[] = '|' . $key . '|iu';
				$with[] = empty($value) ? $highlighter : $value;
			}
			
			return preg_replace($replace, $with, $text);
		} else {
			$phrase = '(' . $phrase . ')';
			if ($considerHtml) {
				$phrase = '(?![^<]+>)' . $phrase . '(?![^<]+>)';
			}
			
			return preg_replace('|'.$phrase.'|iu', $highlighter, $text);
		}
	}
/**
 * Strips given text of all links (<a href=....)
 *
 * @param string $text Text
 * @return string The text without links
 * @access public
 */
	function stripLinks($text) {
		return preg_replace('|<a\s+[^>]+>|im', '', preg_replace('|<\/a>|im', '', $text));
	}
/**
 * Adds links (<a href=....) to a given text, by finding text that begins with
 * strings like http:// and ftp://.
 *
 * @param string $text Text to add links to
 * @param array $htmlOptions Array of HTML options.
 * @return string The text with links
 * @access public
 */
	function autoLinkUrls($text, $htmlOptions = array()) {
		$options = 'array(';
		foreach ($htmlOptions as $option => $value) {
				$value = var_export($value, true);
				$options .= "'$option' => $value, ";
		}
		$options .= ')';

		$text = preg_replace_callback('#(?<!href="|">)((?:http|https|ftp|nntp)://[^ <]+)#i', create_function('$matches',
			'$Html = new HtmlHelper(); $Html->tags = $Html->loadConfig(); return $Html->link($matches[0], $matches[0],' . $options . ');'), $text);

		return preg_replace_callback('#(?<!href="|">)(?<!http://|https://|ftp://|nntp://)(www\.[^\n\%\ <]+[^<\n\%\,\.\ <])(?<!\))#i',
			create_function('$matches', '$Html = new HtmlHelper(); $Html->tags = $Html->loadConfig(); return $Html->link($matches[0], "http://" . strtolower($matches[0]),' . $options . ');'), $text);
	}
/**
 * Adds email links (<a href="mailto:....) to a given text.
 *
 * @param string $text Text
 * @param array $htmlOptions Array of HTML options.
 * @return string The text with links
 * @access public
 */
	function autoLinkEmails($text, $htmlOptions = array()) {
		$options = 'array(';

		foreach ($htmlOptions as $option => $value) {
			$options .= "'$option' => '$value', ";
		}
		$options .= ')';

		return preg_replace_callback('#([_A-Za-z0-9+-]+(?:\.[_A-Za-z0-9+-]+)*@[A-Za-z0-9-]+(?:\.[A-Za-z0-9-]+)*)#',
						create_function('$matches', '$Html = new HtmlHelper(); $Html->tags = $Html->loadConfig(); return $Html->link($matches[0], "mailto:" . $matches[0],' . $options . ');'), $text);
	}
/**
 * Convert all links and email adresses to HTML links.
 *
 * @param string $text Text
 * @param array $htmlOptions Array of HTML options.
 * @return string The text with links
 * @access public
 */
	function autoLink($text, $htmlOptions = array()) {
		return $this->autoLinkEmails($this->autoLinkUrls($text, $htmlOptions), $htmlOptions);
	}
/**
 * Truncates text.
 *
 * Cuts a string to the length of $length and replaces the last characters
 * with the ending if the text is longer than length.
 *
 * @param string  $text String to truncate.
 * @param integer $length Length of returned string, including ellipsis.
 * @param mixed $ending If string, will be used as Ending and appended to the trimmed string. Can also be an associative array that can contain the last three params of this method.
 * @param boolean $exact If false, $text will not be cut mid-word
 * @param boolean $considerHtml If true, HTML tags would be handled correctly
 * @return string Trimmed string.
 */
	function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
		if (is_array($ending)) {
			extract($ending);
		}
		if ($considerHtml) {
			if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}

			preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
			$total_length = strlen($ending);
			$open_tags = array();
			$truncate = '';

			foreach ($lines as $line_matchings) {
				if (!empty($line_matchings[1])) {
					if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
					} elseif (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
						$pos = array_search($tag_matchings[1], $open_tags);
						if ($pos !== false) {
							unset($open_tags[$pos]);
						}
					} elseif (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
						array_unshift($open_tags, strtolower($tag_matchings[1]));
					}
					$truncate .= $line_matchings[1];
				}

				$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
				if ($total_length+$content_length > $length) {
					$left = $length - $total_length;
					$entities_length = 0;
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
						foreach ($entities[0] as $entity) {
							if ($entity[1]+1-$entities_length <= $left) {
								$left--;
								$entities_length += strlen($entity[0]);
							} else {
								break;
							}
						}
					}
					$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
					break;
				} else {
					$truncate .= $line_matchings[2];
					$total_length += $content_length;
				}

				if ($total_length >= $length) {
					break;
				}
			}
		} else {
			if (strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = substr($text, 0, $length - strlen($ending));
			}
		}

		if (!$exact) {
			$spacepos = strrpos($truncate, ' ');
			if (isset($spacepos)) {
				$truncate = substr($truncate, 0, $spacepos);
			}
		}

		$truncate .= $ending;

		if ($considerHtml) {
			foreach ($open_tags as $tag) {
				$truncate .= '</' . $tag . '>';
			}
		}

		return $truncate;
	}
/**
 * Alias for truncate().
 *
 * @see TextHelper::truncate()
 * @access public
 */
	function trim() {
		$args = func_get_args();
		return call_user_func_array(array(&$this, 'truncate'), $args);
	}
/**
 * Extracts an excerpt from the text surrounding the phrase with a number of characters on each side determined by radius.
 *
 * @param string $text String to search the phrase in
 * @param string $phrase Phrase that will be searched for
 * @param integer $radius The amount of characters that will be returned on each side of the founded phrase
 * @param string $ending Ending that will be appended
 * @return string Modified string
 * @access public
 */
	function excerpt($text, $phrase, $radius = 100, $ending = "...") {
		if (empty($text) or empty($phrase)) {
			return $this->truncate($text, $radius * 2, $ending);
		}

		if ($radius < strlen($phrase)) {
			$radius = strlen($phrase);
		}

		$pos = strpos(strtolower($text), strtolower($phrase));
		$startPos = ife($pos <= $radius, 0, $pos - $radius);
		$endPos = ife($pos + strlen($phrase) + $radius >= strlen($text), strlen($text), $pos + strlen($phrase) + $radius);
		$excerpt = substr($text, $startPos, $endPos - $startPos);

		if ($startPos != 0) {
			$excerpt = substr_replace($excerpt, $ending, 0, strlen($phrase));
		}

		if ($endPos != strlen($text)) {
			$excerpt = substr_replace($excerpt, $ending, -strlen($phrase));
		}

		return $excerpt;
	}
/**
 * Creates a comma separated list where the last two items are joined with 'and', forming natural English
 *
 * @param array $list The list to be joined
 * @return string
 * @access public
 */
	function toList($list, $and = 'and') {
		$r = '';
		$c = count($list) - 1;
		foreach ($list as $i => $item) {
			$r .= $item;
			if ($c > 0 && $i < $c)
			{
				$r .= ($i < $c - 1 ? ', ' : " {$and} ");
			}
		}
		return $r;
	}
/**
 * Text-to-html parser, similar to Textile or RedCloth, only with a little different syntax.
 *
 * @param string $text String to "flay"
 * @param boolean $allowHtml Set to true if if html is allowed
 * @return string "Flayed" text
 * @access public
 * @todo Change this. We need a real Textile parser.
 * @codeCoverageIgnoreStart
 */
	function flay($text, $allowHtml = false) {
		trigger_error(__('(TextHelper::flay) Deprecated: the Flay library is no longer supported and will be removed in a future version.', true), E_USER_WARNING);
		if (!class_exists('Flay')) {
			uses('flay');
		}
		return Flay::toHtml($text, false, $allowHtml);
	}
/**
 * @codeCoverageIgnoreEnd
 */
}
?>