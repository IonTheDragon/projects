<?php
class Complex {

    public $real_value;
    public $imaginary_value;

	public function __construct(float $real, float $imaginary = 0) {
        $this->real_value = $real;
        $this->imaginary_value = $imaginary;	
	}

	public function complex_text() {
		$text_output = $this->real_value;
		if($this->imaginary_value >= 0) {
			$text_output .= '+' . $this->imaginary_value . 'i';			
		} else {
			$text_output .= $this->imaginary_value . 'i';
		}
		return $text_output;
	}	
}

function summary(Complex ...$numbers) {
    $sum_real = 0;
	$sum_imaginary = 0;
    foreach ($numbers as $n) {
        $sum_real += $n->real_value;
		$sum_imaginary += $n->imaginary_value;
    }
    return new Complex($sum_real, $sum_imaginary);	
}

function subtraction(Complex ...$numbers) {
	if(!count($numbers)) {
		return new Complex(0, 0);	
	}	
    $sub_real = $numbers[0]->real_value;
	$sub_imaginary = $numbers[0]->imaginary_value;
    foreach ($numbers as $key => $n) {
		if($key) {
			$sub_real -= $n->real_value;
			$sub_imaginary -= $n->imaginary_value;
		}
    }
    return new Complex($sub_real, $sub_imaginary);	
}

//(a+bi)*(c+di)=(ac-bd)+(bc+ad)i
function multiplication(Complex ...$numbers) {
	if(!count($numbers)) {
		return new Complex(0, 0);	
	}	
	if(count($numbers) == 1) {
		return new Complex($numbers[0]->real_value, $numbers[0]->imaginary_value);	
	}

    $mult_real = $numbers[0]->real_value;
	$mult_imaginary = $numbers[0]->imaginary_value;
    foreach ($numbers as $key => $n) {	
		if($key) {
			$a = $mult_real;
			$b = $mult_imaginary;
			$c = $n->real_value;
			$d = $n->imaginary_value;
			
			$mult_real = $a*$c - $b*$d;
			$mult_imaginary = $b*$c + $a*$d;
		}
    }
    return new Complex($mult_real, $mult_imaginary);	
	
}

//(a+bi)/(c+di)=(ac+bd)/(c^2+d^2)+((bc-ad)/(c^2+d^2))i
function division(Complex ...$numbers) {
	if(!count($numbers)) {
		throw new Exception('Не указано делимое');		
	}	
	if(count($numbers) == 1) {
		throw new Exception('Не указан делитель');		
	}

    $div_real = $numbers[0]->real_value;
	$div_imaginary = $numbers[0]->imaginary_value;
    foreach ($numbers as $key => $n) {	
		if($key) {
			$a = $div_real;
			$b = $div_imaginary;
			$c = $n->real_value;
			$d = $n->imaginary_value;
			
			if (!$c && !$d) {
				throw new Exception('Деление на ноль.');
			}			
			
			$div_real = ($a*$c + $b*$d) / (pow($c, 2) + pow($d, 2));
			$div_imaginary = ($b*$c - $a*$d) / (pow($c, 2) + pow($d, 2));
		}
    }
    return new Complex($div_real, $div_imaginary);	
	
}