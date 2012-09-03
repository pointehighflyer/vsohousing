<?php


//generic Form class, handles low level form tasks
//such as creation and validation of specific element types
class Form{

	var $globalArr = array(); //either 'post' or 'get', used by validation functions
			     //to retrieve the input
	var $errorStatus = 0; //whether the form cotains an error or not
	var $mode;
	var $dayList = array();
	var $monthList = array();
	var $yearList = array();

	
				 
	function Form($method){
		if(isset($_SESSION['update'])){
			$this->mode = 'update';
		}
		//echo 'called form constructor<br/>';
		if($method == 'get'){
			//echo 'method is GET<br/>';
			$this->globalArr = &$_GET;
		}
		else{
			//echo 'method is POST<br/>';
			$this->globalArr = &$_POST;
		}
		$this->dayList['Day'] = '00';
		$this->dayList['1'] = '01';
		$this->dayList['2'] = '02';
		$this->dayList['3'] = '03';
		$this->dayList['4'] = '04';
		$this->dayList['5'] = '05';
		$this->dayList['6'] = '06';
		$this->dayList['7'] = '07';
		$this->dayList['8'] = '08';
		$this->dayList['9'] = '09';
		$this->dayList['10'] = '10';
		$this->dayList['11'] = '11';
		$this->dayList['12'] = '12';
		$this->dayList['13'] = '13';
		$this->dayList['14'] = '14';
		$this->dayList['15'] = '15';
		$this->dayList['16'] = '16';
		$this->dayList['17'] = '17';
		$this->dayList['18'] = '18';
		$this->dayList['19'] = '19';
		$this->dayList['20'] = '20';
		$this->dayList['21'] = '21';
		$this->dayList['22'] = '22';
		$this->dayList['23'] = '23';
		$this->dayList['24'] = '24';
		$this->dayList['25'] = '25';
		$this->dayList['26'] = '26';
		$this->dayList['27'] = '27';
		$this->dayList['28'] = '28';
		$this->dayList['29'] = '29';
		$this->dayList['30'] = '30';
		$this->dayList['31'] = '31';
		$this->monthList['Month'] = '00';
		$this->monthList['January'] = '01';
		$this->monthList['February'] = '02';
		$this->monthList['March'] = '03';
		$this->monthList['April'] = '04';
		$this->monthList['May'] = '05';
		$this->monthList['June'] = '06';
		$this->monthList['July'] = '07';
		$this->monthList['August'] = '08';
		$this->monthList['September'] = '09';
		$this->monthList['October'] = '10';
		$this->monthList['November'] = '11';
		$this->monthList['December'] = '12';
		$this->yearList['Year'] = '0000';
		for ($i=intval(date('Y',strtotime('+4 years')));$i>1969;$i--){
			$this->yearList[strval($i)] = strval($i);
		}
		/*$this->yearList['2020'] = '2020';
		$this->yearList['2019'] = '2019';
		$this->yearList['2018'] = '2018';
		$this->yearList['2017'] = '2017';
		$this->yearList['2016'] = '2016';
		$this->yearList['2015'] = '2015';
		$this->yearList['2014'] = '2014';
		$this->yearList['2013'] = '2013';
		$this->yearList['2012'] = '2012';
		$this->yearList['2011'] = '2011';
		$this->yearList['2010'] = '2010';
		$this->yearList['2009'] = '2009';
		$this->yearList['2008'] = '2008';
		$this->yearList['2007'] = '2007';
		$this->yearList['2006'] = '2006';
		$this->yearList['2005'] = '2005';
		$this->yearList['2004'] = '2004';
		$this->yearList['2003'] = '2003';
		$this->yearList['2002'] = '2002';
		$this->yearList['2001'] = '2001';
		$this->yearList['2000'] = '2000';
		$this->yearList['1999'] = '1999';
		$this->yearList['1998'] = '1998';
		$this->yearList['1997'] = '1997';
		$this->yearList['1996'] = '1996';
		$this->yearList['1995'] = '1995';
		$this->yearList['1994'] = '1994';
		$this->yearList['1993'] = '1993';
		$this->yearList['1992'] = '1992';
		$this->yearList['1991'] = '1991';
		$this->yearList['1990'] = '1990';
		$this->yearList['1989'] = '1989';
		$this->yearList['1988'] = '1988';
		$this->yearList['1987'] = '1987';
		$this->yearList['1986'] = '1986';
		$this->yearList['1985'] = '1985';
		$this->yearList['1984'] = '1984';
		$this->yearList['1983'] = '1983';
		$this->yearList['1982'] = '1982';
		$this->yearList['1981'] = '1981';
		$this->yearList['1980'] = '1980';
		$this->yearList['1979'] = '1979';
		$this->yearList['1978'] = '1978';
		$this->yearList['1977'] = '1977';
		$this->yearList['1976'] = '1976';
		$this->yearList['1975'] = '1975';
		$this->yearList['1974'] = '1974';
		$this->yearList['1973'] = '1973';
		$this->yearList['1972'] = '1972';
		$this->yearList['1971'] = '1971';
		$this->yearList['1970'] = '1970';*/
	} 
	
	//gets the integer equivalent of the specified field
	//if integer is >= 0 it is returned, otherwise -1 is returned
	//could do this with regex.....
	function getNumeric($name){
		if($this->globalArr[$name] != '' && ctype_digit($this->globalArr[$name]) && (int)$this->globalArr[$name] >= 0){
			return (int)$this->globalArr[$name];
		}
		else{return -1;}
	}
	
	//sanitize the specified field
	function sanitize($name){
		$data = $this->globalArr[$name];
		//echo '<p>Data Set To 1:  '.$data.'</p>';
		if(get_magic_quotes_gpc()){
			$data = stripslashes($data);
		}
		//echo '<p>Data Set To 2:  '.$data.'</p>';
		//$data = htmlentities($data);
		//echo '<p>Data Set To 3:  '.$data.'</p>';
		$data = mysql_escape_string($data);
		//echo '<p>Data Set To 4:  '.$data.'</p>';
		return $data;
	}
		
	
	
	
	//validates whether the field is blank
	function validateGeneric($name){
		if($this->globalArr[$name] == ''){
			return 0;
		}
		else{return 1;}
		//return empty($this->globalArr[$name]);
	}
	
	
	//validates an email address with regex
	function validateEmail($name){
		if(isset($this->globalArr[$name])){
			return preg_match("/^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$/",$globalArr[$name]);
		}
		else{return 0;}
	}
	
	
	//validates a phone number with regex
	function validatePhone($name){
		//echo '<p>Entered validatePhone<br/>'.$this->globalArr[$name].'</p>';		
		if($this->globalArr[$name] != ''){
			//echo '<p>MATCH: '.preg_match('/^(?:\([2-9]\d{2}\)\ ?|[2-9]\d{2}(?:\-?|\ ?))[2-9]\d{2}[- ]?\d{4}$/',$this->globalArr[$name]).'</p>';
			return preg_match('/^(?:\([2-9]\d{2}\)\ ?|[2-9]\d{2}(?:\-?|\ ?))[2-9]\d{2}[- ]?\d{4}$/',$this->globalArr[$name]);
		}
		else{
			//echo '<p>Number not valid</p>';
			return 0;
		}
	}
	
	function makeRadio($name, $value, $checked){
		$element = '<input type="radio" name="'.$name.'" value="'.$value.'" id="'.$name.'" ';
		if($checked){
			$element .= 'checked="checked"';
		}
		$element .= '/>';
		return $element;
	}

	function makeCheck($name, $value, $checked){
		$element = '<input type="checkbox" name="'.$name.'" value="'.$value.'" id="'.$name.'" ';
		if($checked){
			$element .= 'checked="checked"';
		}
		$element .= '/>';
		return $element;
	}
	//builds a selection list
	function makeList($name, $values){
		$text = '<select name="'.$name.'">';
		foreach($values as $k=>$v){
			$selected = '';
			if($v == 1){
				$selected = 'selected="selected"';
			}	
			$text .= '<option value="'.$k.'" '.$selected.'>'.$k.'</option>';
        }
        $text.='</select>';
        return $text;
	}
	
	//1st revision, DEPRECATED
	function makeListL($name, $values, $labels){
		$text = '<select name="'.$name.'">';
		foreach($values as $k=>$v){
			$selected = '';
			if($v == 1){
				$selected = 'selected="selected"';
			}	
			$text .= '<option value="'.$k.'" '.$selected.'>'.$labels[$k].'</option>';
        }
        $text.='</select>';
        return $text;
	}
	
	//2nd revision
	function makeListS($name, $values, $selected){
		$text = '<select name="'.$name.'" id="'.$name.'">'."\n";
		foreach($values as $k=>$v){
			$select = '';
			if($v == $selected){
				$select = 'selected="selected"';
			}	
			$text .= "\t".'<option value="'.$v.'" '.$select.'>'.$k.'</option>'."\n";
        }
        $text.='</select>'."\n";
        return $text;
	}
	
	//make dropdowns to select the date with params to specify the names
	//of the fields as well as defaut selection
	//date string formatted as YYYY-MM-DD (MySQL)
	function makeDateSelect($dName, $mName, $yName, $date){
		$parse = explode('-',$date);
		$text  = $this->makeListS($mName, $this->monthList, $parse[1]). ' '.
				$this->makeListS($dName, $this->dayList, $parse[2]).' '.
				$this->makeListS($yName, $this->yearList, $parse[0]);
		return $text;
	}
	
	function makeText($name, $value, $error){
		$element = '<input type="text" name="'.$name.'" value="'.$value.'" id="'.$name.'" ';
		if($error){
			$element .= 'class="formerror"';
		}
		$element .= '/>';
		return $element;
	}
	
	function makeTextArea($name, $value, $rows, $cols){
		$element = '<textarea name="'.$name.'" id="'.$name.'" rows="'.$rows.'" cols="'.$cols.'">'.$value.'</textarea>';
		return $element;
	}
	
	function makeLabel($for,$name){
		$e = '<label for="'.$for.'">'.$name.'</label>';
		return $e;
	}
	
	function makeHidden($name, $value){
		$element = '<input type="hidden" name="'.$name.'" value="'.$value.'"/>';
		return $element;
	}
	
	function makeSubmit($name, $value){
		$element = '<input type="submit" name="'.$name.'" value="'.$value.'"/>';
		return $element;
	}
	
	function stripChars($str){
		$match = array('\r\n','\n','\\');
		$replace = array("\r\n","\n",'');
		$str = str_replace($match,$replace,$str);
		//$str = str_replace('\\','^^^',$str);
		//$str = htmlspecialchars($str);
		return $str;
	}
	
}


?>