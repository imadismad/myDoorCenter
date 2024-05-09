<?php
require_once "Option.php";

/**
 * Use to represent an Array of buying option (Option)
 */
class OptionArray {
    private array $array;

    public function __construct(Option ...$items) {
        $this -> array = [];
        array_push($this -> array, ...$items);
    }

    /**
     * Add one or more element at the end of the array
     * @param Option $items the element(s) to add
     */
    public function append(Option ...$items) {
        array_push($this -> array, ...$items);
    }

    /**
     * Prepend one or more element at the beginning of the array
     * @param Option $items the element(s) to add
     */
    public function unshift(Option ...$items) {
        array_unshift($this -> array, ...$items);
    }

    /**
     * Shift an element at the beginning of the array
     *  @return Option|null The first element of the array. If empty return null
     */
    public function shift(): Object {
        return array_shift($this -> array);
    }

    /**
     * Remove the last element of the array
     * @return Option|null The last element of the array. If empty return null
     */
    public function pop(): Option {
        return array_pop($this -> array);
    }

    /**
     * Removes the elements designated by offset and length from the array array,
     * and replaces them with the elements of the replacement array, if supplied.
     * 
     * @param int $offset If offset is positive then the start of the removed
     * portion is at that offsetfrom the beginning of the array array. If offset is negative
     * then the start of the removed portion is at that offset from the end of the array array.
     * 
     * @param  int|null If length is omitted, removes everything from offset to the end of the array.
     * If length is specified and is positive, then that many elements will be removed.
     * If length is specified and is negative, then the end of the removed portion will
     * be that many elements from the end of the array.
     * If length is specified and is zero, no elements will be removed.
     * 
     * @param OptionArray $replacement  If replacement array is specified,
     * then the removed elements are replaced with elements from this array.
     * If offset and length are such that nothing is removed, 
     * then the elements from the replacement array are inserted in the place specified by the offset. 
     * 
     * @return OptionArray Returns an array consisting of the extracted elements
     */
    public function splice(int $offset, int|null $lenght = null, OptionArray $replacement = new OptionArray()): OptionArray {
        $unTypedReplacement = $replacement -> toRegularArray();
        $values = array_splice($this -> array, $offset, $lenght, $unTypedReplacement);

        return new OptionArray(...$values);
    }

    /**
     * Extract a slice of the array
     * Returns the sequence of elements from the array array as specified by the offset and length parameters.
     * 
     * @param int $offset If offset is positive then the start of the removed
     * portion is at that offsetfrom the beginning of the array array. If offset is negative
     * then the start of the removed portion is at that offset from the end of the array array.
     * 
     * @param int|null $lenght If length is given and is positive, then the sequence will have up to that many elements in it.
     * If the array is shorter than the length, then only the available array elements will be present.
     * If length is given and is negative then the sequence will stop that many elements from the end of the array. 
     * If it is omitted, then the sequence will have everything from offset up until the end of the array.
     * 
     * @param boolean $preserve_keys will reorder and reset the integer array indices by default.
     * This behaviour can be changed by setting preserve_keys to true.
     */
    public function slice(int $offset, int|null $lenght = null, bool $preserve_keys = false): OptionArray {
        $values = array_slice($this -> array, $offset, $lenght, $preserve_keys);
        return new OptionArray(...$values);
    }

    /**
     * This function return a reprensentation of the object in array
     * @return array a reprensentation of the object
     */
    public function toRegularArray(): array {
        return $this -> array;
    }

    /**
     * Return the value at the index
     * @param int $index the index of the value
     * @return Option the value at th given index
     */
    public function get(int $index): Option {
        return $this-> array[$index];
    }

    /**
     * Return the size of the array
     * @return int the actual size
     */
    public function count(): int {
        return count($this -> array);
    }

    public function toIdsRequete(): string {
        if ($this -> count() === 0) return "";
        $str = $this -> get(0) -> getId();
        for ($i = 1; $i < $this ->count(); $i++) {
            $str .= "|".$this -> get($i) -> getId();
        }
        return $str;
    }

    /**
     * Return the ids of the option in the array
     * @return array the ids of the option in the array
     */
    public function getIds(): array {
        $ids = [];
        foreach ($this -> array as $option) {
            array_push($ids, $option -> getId());
        }
        return $ids;
    }

    /**
     * This function return the sum of the price of all the option in the array
     * @return int the sum of the price of all the option in the array
     */
    public function getPrice(): int {
        $price = 0;
        foreach ($this -> array as $option) {
            $price += $option -> getPrice();
        }
        return $price;
    }
}