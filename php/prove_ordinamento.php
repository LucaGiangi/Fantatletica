function array_sort($array, $on, $order)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function compare($v1,$v2t,$param){
	
		/*if ($v[$param] >= $pivot[$param])
			if ($v[$param] == $pivot[$param])
				return 2;
			else
				return 1;
			else
		return 0;*/	
		
		if ($v1['Punti']<=$v2['Punti'])
		if($v1['Punti']==$v2['Punti'])
			if ($v1['Costo']<=$v2['Costo'])
				if ($v1['Costo']==$v2['Costo'])
					return $v1['Numero']>=$v2['Numero'];
				else
					return false;
			else
				return true;
		else
			return true;
	else
		return false;
	
}
function quick_sort($array)
{
	// find array size
	$length = count($array);
	
	// base case test, if array of length 0 then just return array to caller
	if($length <= 1){
		return $array;
	}
	else{
	
		// select an item to act as our pivot point, since list is unsorted first position is easiest
		$pivot = $array[0];
		
		// declare our two arrays to act as partitions
		$left = $right = array();
		
		// loop and compare each item in the array to the pivot value, place item in appropriate partition
		for($i = 1; $i < count($array); $i++)
		{
			/*if($array[$i] < $pivot){
				$left[] = $array[$i];
			}
			else{
				$right[] = $array[$i];
			}*/
			$ris=compare($array[$i],$pivot,'');
			if (!$ris)		
				$left[] = $array[$i];
			else
				$right[] = $array[$i];
			}
		
		// use recursion to now sort the left and right lists
		return array_merge(quick_sort($left), array($pivot), quick_sort($right));
	}
}
function quicksort($array,$param) {
    if( count( $array ) < 2 ) {
        return $array;
    }
    $left = $right = array( );
    reset( $array );
    $pivot_key  = key( $array );
    $pivot  = array_shift( $array );
    foreach( $array as $k => $v ) {
		
		$ris=compare($v,$pivot,$param);
		if (!$ris)		
			$left[$k] = $v;
        else
            $right[$k] = $v;
       
    }
    //return array_merge(quicksort(array_sort($left,'Costo', SORT_ASC)), array($pivot_key => $pivot), quicksort(array_sort($right,'Costo', SORT_ASC)));
	return array_merge(quicksort($left,$param), array($pivot_key => $pivot), quicksort($right,$param));
}