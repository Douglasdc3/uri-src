<?php
/**
 * League.Uri (http://uri.thephpleague.com)
 *
 * @package   League.uri
 * @author    Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @copyright 2013-2015 Ignace Nyamagana Butera
 * @license   https://github.com/thephpleague/uri/blob/master/LICENSE (MIT License)
 * @version   4.2.0
 * @link      https://github.com/thephpleague/uri/
 */
namespace League\Uri\Types;

/**
 * Uri Parameter validation
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.2.0
 */
trait TranscoderTrait
{
    /**
     * Encoded Characters regular expression pattern
     *
     * @see http://tools.ietf.org/html/rfc3986#section-2.1
     *
     * @var string
     */
    protected static $encodedChars = '[A-Fa-f0-9]{2}';

    /**
     * RFC3986 Sub delimiter characters regular expression pattern
     *
     * @see http://tools.ietf.org/html/rfc3986#section-2.2
     *
     * @var string
     */
    protected static $subdelimChars = "\!\$&'\(\)\*\+,;\=%";

    /**
     * RFC3986 unreserved characters regular expression pattern
     *
     * @see http://tools.ietf.org/html/rfc3986#section-2.3
     *
     * @var string
     */
    protected static $unreservedChars = 'A-Za-z0-9_\-\.~';

    /**
     * RFC3986 unreserved characters encoded regular expression pattern
     *
     * @see http://tools.ietf.org/html/rfc3986#section-2.3
     *
     * @var string
     */
    protected static $unreservedCharsEncoded = '2[D|E]|3[0-9]|4[1-9|A-F]|5[0-9|A|F]|6[1-9|A-F]|7[0-9|E]';

    /**
     * Encode a component string
     *
     * @param string $str     The string to encode
     * @param string $pattern a regular expression pattern
     *
     * @return string
     */
    protected static function encode($str, $pattern)
    {
        $regexp = '/(?:[^'.self::$unreservedChars.$pattern.']+|%(?!'.self::$encodedChars.'))/';
        $encoder = function (array $matches) {
            return rawurlencode($matches[0]);
        };

        $str = preg_replace_callback($regexp, $encoder, $str);
        $formatter = function (array $matches) {
            return strtoupper($matches[0]);
        };

        return preg_replace_callback(',%'.self::$encodedChars.',', $formatter, $str);
    }

    /**
     * Encode a user string according to RFC3986 Rules
     *
     * @param string $str
     *
     * @return string
     */
    protected static function encodeUser($str)
    {
        return self::encode($str, self::$subdelimChars);
    }

    /**
     * Encode a user string according to RFC3986 Rules
     *
     * @param string $str
     *
     * @return string
     */
    protected static function encodePass($str)
    {
        return self::encode($str, self::$subdelimChars.'\:');
    }

    /**
     * Encode a path string according to RFC3986
     *
     * @param string $str can be a string or an array
     *
     * @return string The same type as the input parameter
     */
    protected static function encodePath($str)
    {
        return self::encode($str, self::$subdelimChars.'\:\/@');
    }

    /**
     * Encode a string according to RFC3986 Rules
     *
     * @param string $str
     *
     * @return string
     */
    protected static function encodeQueryFragment($str)
    {
        return self::encode($str, self::$subdelimChars.'\:\/@\?');
    }

    /**
     * Decode a component string
     *
     * @param string $str     The string to decode
     * @param string $pattern a regular expression pattern
     *
     * @return string
     */
    protected static function decode($str, $pattern)
    {
        $regexp = ',%'.$pattern.',i';
        $decoder = function (array $matches) use ($regexp) {

            if (preg_match($regexp, $matches[0])) {
                return strtoupper($matches[0]);
            }

            return rawurldecode($matches[0]);
        };

        return preg_replace_callback(',%'.self::$encodedChars.',', $decoder, $str);
    }

    /**
     * Decode a component according to RFC3986
     *
     * @param string $str
     *
     * @return string
     */
    protected static function decodeComponent($str)
    {
        return self::decode($str, self::$unreservedCharsEncoded);
    }

    /**
     * Decode a path component according to RFC3986
     *
     * @param string $str
     *
     * @return string
     */
    protected static function decodePath($str)
    {
        return self::decode($str, self::$unreservedCharsEncoded.'|2F');
    }
}
