<?php
/**
* Bakame.url - A lightweight Url Parser library
*
* @author Ignace Nyamagana Butera <nyamsprod@gmail.com>
* @copyright 2013 Ignace Nyamagana Butera
* @link https://github.com/nyamsprod/Bakame.url
* @license http://opensource.org/licenses/MIT
* @version 1.0.0
* @package Bakame.url
*
* MIT LICENSE
*
* Permission is hereby granted, free of charge, to any person obtaining
* a copy of this software and associated documentation files (the
* "Software"), to deal in the Software without restriction, including
* without limitation the rights to use, copy, modify, merge, publish,
* distribute, sublicense, and/or sell copies of the Software, and to
* permit persons to whom the Software is furnished to do so, subject to
* the following conditions:
*
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
* MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
* LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
* OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
* WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace Bakame\Url;

class Segment
{
    /**
     * Segment separator
     * @var string
     */
    private $separator;

    /**
     * Segment Data
     * @var array
     */
    private $data = array();

    public function __construct($str, $separator)
    {
        $this->separator = $separator;
        if (! is_null($str)) {
            if ($this->separator == $str[0]) {
                $str = substr($str, 1);
            }
            $this->data = explode($this->separator, $str);
        }
    }

    /**
     * check if the value is present in the Segment data
     *
     * @param string $name the value to check
     *
     * @return boolean
     */
    public function has($name)
    {
        return in_array($name, $this->data);
    }

    /**
     * get the query data
     * if a index is provided it will return its associated data of null
     * if not index is provided it will return the whole data
     *
     * @param null|integer $index the index
     *
     * @return mixed
     */
    public function get($index = null)
    {
        if (null === $index) {
            return $this->data;
        } elseif (array_key_exists($index, $this->data)) {
            return $this->data[$index];
        }

        return null;
    }

    /**
     * Set Host values
     * @param mixed   $value            a string OR an array representing the data to be inserted
     * @param string  $position         append or prepend where to insert the data in the host array
     * @param integer $valueBefore      the data where to append the $value
     * @param integer $valueBeforeIndex the occurenceIndex of $valueBefore if $valueBefore appears more than once
     *
     * @return self
     */
    public function set($value, $position = 'append', $valueBefore = null, $valueBeforeIndex = null)
    {
        if (! in_array($position, array('append', 'prepend'))) {
            $position = 'append';
        }

        return $this->$position($value, $valueBefore, $valueBeforeIndex);
    }

    /**
     * remove values from the segment
     * @param mixed $value a string OR an array representing the data to be removed
     *
     * @return self
     */
    public function remove($name)
    {
        $name = (array) $name;
        $this->data = array_filter($this->data, function ($value) use ($name) {
            return ! in_array($value, $name);
        });

        return $this;
    }

    /**
     * Clear segment data
     *
     * @return self
     */
    public function clear()
    {
        $this->data = array();

        return $this;
    }

    /**
     * append values to Segment
     * @param mixed   $value            a string OR an array representing the data to be inserted
     * @param integer $valueBefore      the data where to append the $value
     * @param integer $valueBeforeIndex the occurenceIndex of $valueBefore if $valueBefore appears more than once
     *
     * @return self
     */
    private function append($value, $valueBefore = null, $valueBeforeIndex = null)
    {
        $new = (array) $value;
        $old = $this->get();
        $extra = [];
        if (null !== $valueBefore && count($found = array_keys($old, $valueBefore))) {
            $index = $found[0];
            if (array_key_exists($valueBeforeIndex, $found)) {
                $index = $found[$valueBeforeIndex];
            }
            $extra = array_slice($old, $index+1);
            $old = array_slice($old, 0, $index+1);
        }
        $this->data = array_merge($old, $new, $extra);

        return $this;
    }

    /**
     * prepend values to Segment
     * @param mixed   $value            a string OR an array representing the data to be inserted
     * @param integer $valueBefore      the data where to append the $value
     * @param integer $valueBeforeIndex the occurenceIndex of $valueBefore if $valueBefore appears more than once
     *
     * @return self
     */
    private function prepend($value, $valueBefore = null, $valueBeforeIndex = null)
    {
        $new = (array) $value;
        $old = $this->get();
        if (null !== $valueBefore && count($found = array_keys($old, $valueBefore))) {
            $index = $found[0];
            if (array_key_exists($valueBeforeIndex, $found)) {
                $index = $found[$valueBeforeIndex];
            }
            $extra = array_slice($old, $index);
            $old = array_slice($old, 0, $index);
            $this->data = array_merge($old, $new, $extra);

            return $this;
        }
        $this->data = array_merge($new, $old);

        return $this;
    }

    /**
     * format the string representation
     * @return string
     */
    public function __toString()
    {
        return implode($this->separator, $this->data);
    }
}
