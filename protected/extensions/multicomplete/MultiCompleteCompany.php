<?php
Yii::import('zii.widgets.jui.CJuiAutoComplete');

class MultiCompleteCompany extends CJuiAutoComplete
{
    public $splitter = ",";
    
    public $updater = '';
    
	/**
	 * Run this widget.
	 * This method registers necessary javascript and renders the needed HTML code.
	 */
	public function run()
	{
		list($name,$id)=$this->resolveNameID();
		
		if(!isset($this->updater) || empty($this->updater)){
			$this->updater = 's_'.time();
		}

		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;

		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];

		if($this->hasModel())
			echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
		else
			echo CHtml::textField($name,$this->value,$this->htmlOptions);

		if($this->sourceUrl!==null)
          {
            $this->source = 'function( request, response ) {$.getJSON( "'.CHtml::normalizeUrl($this->sourceUrl).'", {
             term: extractLast( request.term )
            }, response );
			}';
          } else {
          	$aPreparedSource = array();
          	foreach($this->source as $iId => $sName){
          		$aPreparedSource[] = array(
          			'id' => $iId,
          			'value' => $sName
          		);
          	}
			//$this->options['source']=$this->source;
            $this->source = 'function( request, response ) {
				// delegate back to autocomplete, but extract the last term
				response( $.ui.autocomplete.filter(
					'.CJavaScript::encode($aPreparedSource).', extractLast( request.term ) ) );
			}';//CJavaScript::encode($this->source);
          }

          if(isset($this->options['minLength']))
			$ml=$this->options['minLength'];
          else
               $ml=0;

		$options=CJavaScript::encode($this->options);

        $joiner = $this->splitter." ";
		//$js = "jQuery('#{$id}').autocomplete($options);";
        $js = 'jQuery(function($){
            function split( val ) {
                return val.split( /'.$this->splitter.'\s*/ );
            }
        
            function extractLast( term ) {
                return split( term ).pop();
            }
            
            $( "#'.$id.'" ).autocomplete({
                source: '.$this->source.',

                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },

                search: function() {
                    // custom minLength
                    var term = extractLast( this.value );
                    if ( term.length < '.$ml.' ) {
                         return false;
                    }
               },


                select: function( event, ui ) {
                    var terms = split( this.value );
                    var ids = split($("#'.$this->updater.'").val());
                    // remove the current input
                    terms.pop();
                    ids.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    ids.push(ui.item.value);
                    //'.$this->updater.'.push( ui.item.id );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    ids.push( "" );
                    //this.value = terms.join( "'.$joiner.'" );
                    this.value = "Search company here...";
                    $("#'.$this->updater.'").val(ids.join( "'.$joiner.'" ));
                    return false;
                }
            }); 
            $( "#'.$id.'" ).autocomplete("option",'.$options.');             
        })';

		$cs = Yii::app()->getClientScript();
		$cs->registerScript(__CLASS__.'#'.$id, $js);
	}
}
