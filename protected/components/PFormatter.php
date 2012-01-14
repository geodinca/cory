<?php
/**
 * CFormatter class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CFormatter provides a set of commonly used data formatting methods.
 *
 * The formatting methods provided by CFormatter are all named in the form of <code>formatXyz</code>.
 * The behavior of some of them may be configured via the properties of CFormatter. For example,
 * by configuring {@link dateFormat}, one may control how {@link formatDate} formats the value into a date string.
 *
 * For convenience, CFormatter also implements the mechanism of calling formatting methods with their shortcuts (called types).
 * In particular, if a formatting method is named <code>formatXyz</code>, then its shortcut method is <code>xyz</code>
 * (case-insensitive). For example, calling <code>$formatter->date($value)</code> is equivalent to calling
 * <code>$formatter->formatDate($value)</code>.
 *
 * Currently, the following types are recognizable:
 * <ul>
 * <li>raw: the attribute value will not be changed at all.</li>
 * <li>text: the attribute value will be HTML-encoded when rendering.</li>
 * <li>ntext: the {@link formatNtext} method will be called to format the attribute value as a HTML-encoded plain text with newlines converted as the HTML &lt;br /&gt; tags.</li>
 * <li>html: the attribute value will be purified and then returned.</li>
 * <li>date: the {@link formatDate} method will be called to format the attribute value as a date.</li>
 * <li>time: the {@link formatTime} method will be called to format the attribute value as a time.</li>
 * <li>datetime: the {@link formatDatetime} method will be called to format the attribute value as a date with time.</li>
 * <li>boolean: the {@link formatBoolean} method will be called to format the attribute value as a boolean display.</li>
 * <li>number: the {@link formatNumber} method will be called to format the attribute value as a number display.</li>
 * <li>email: the {@link formatEmail} method will be called to format the attribute value as a mailto link.</li>
 * <li>image: the {@link formatImage} method will be called to format the attribute value as an image tag where the attribute value is the image URL.</li>
 * <li>url: the {@link formatUrl} method will be called to format the attribute value as a hyperlink where the attribute value is the URL.</li>
 * </ul>
 *
 * By default, {@link CApplication} registers {@link CFormatter} as an application component whose ID is 'format'.
 * Therefore, one may call <code>Yii::app()->format->boolean(1)</code>.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CFormatter.php 2799 2011-01-01 19:31:13Z qiang.xue $
 * @package system.utils
 * @since 1.1.0
 */
class PFormatter extends CFormatter
{
	private $_htmlPurifier;

	/**
	 * Formats the value as a date.
	 * @param mixed $value the value to be formatted
	 * @return string the formatted result
	 * @see dateFormat
	 */
	public function formatDate($value)
	{
		return $value ? date($this->dateFormat, strtotime($value)) : null;
	}

	/**
	 * Formats the value as a time.
	 * @param mixed $value the value to be formatted
	 * @return string the formatted result
	 * @see timeFormat
	 */
	public function formatTime($value)
	{
		return date($this->timeFormat,strtotime($value));
	}

	/**
	 * Formats the value as a date and time.
	 * @param mixed $value the value to be formatted
	 * @return string the formatted result
	 * @see datetimeFormat
	 */
	public function formatDatetime($value)
	{
		return date($this->datetimeFormat,strtotime($value));
	}
	
	/**
	 * Formats the value as a n,nnn.nn
	 * @param mixed $value the value to be formatted
	 * @return string the formatted result
	 */
	public function formatPrice($value)
	{
		return number_format($value, 2, '.', ',');
	}
	
	
	/**
	 * Format enum database fields as array for slect box
	 * @return array
	 */
	public function formatEnumToArray($value){
		preg_match_all('/\'(.*?)\'/', $value, $tmp);
		asort($tmp[1]);
		return array_combine($tmp[1], $tmp[1]);
	}
	
	/**
	 * Jedit selectbox
	 * @param CActiveRecord $value
	 * @return string
	 */
	public function formatJeditSelect(CActiveRecord $value){
		$sResult = '';
		$iId = $value->ballance->id;
		$sStatus = $value->ballance->status;
		
		return '<div id="'.$iId.'" class="edit_select">'.$sStatus.'</div';
	}
}
