<?php
/**
* This file is part of the League.url library
*
* @license http://opensource.org/licenses/MIT
* @link https://github.com/thephpleague/url/
* @version 3.2.0
* @package League.url
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace League\Url;

use League\Url\Components\Scheme;
use League\Url\Components\User;
use League\Url\Components\Pass;
use League\Url\Components\Port;
use League\Url\Components\Fragment;
use League\Url\Components\HostInterface;
use League\Url\Components\PathInterface;
use League\Url\Components\QueryInterface;

/**
 * A Immutable Value Object class to manipulate URLs
 *
 *  @package League.url
 *  @since  3.0.0
 */
class UrlImmutable extends AbstractUrl
{
    /**
     * The Constructor
     * @param Scheme         $scheme   The URL Scheme component
     * @param User           $user     The URL User component
     * @param Pass           $pass     The URL Pass component
     * @param HostInterface  $host     The URL Host component
     * @param Port           $port     The URL Port component
     * @param PathInterface  $path     The URL Path component
     * @param QueryInterface $query    The URL Query component
     * @param Fragment       $fragment The URL Fragment component
     */
    protected function __construct(
        Scheme $scheme,
        User $user,
        Pass $pass,
        HostInterface $host,
        Port $port,
        PathInterface $path,
        QueryInterface $query,
        Fragment $fragment
    ) {
        $this->scheme = clone $scheme;
        $this->user = clone $user;
        $this->pass = clone $pass;
        $this->host = clone $host;
        $this->port = clone $port;
        $this->path = clone $path;
        $this->query = clone $query;
        $this->fragment = clone $fragment;
    }

    /**
     * To Enable cloning
     */
    public function __clone()
    {
        $this->scheme = clone $this->scheme;
        $this->user = clone $this->user;
        $this->pass = clone $this->pass;
        $this->host = clone $this->host;
        $this->port = clone $this->port;
        $this->path = clone $this->path;
        $this->query = clone $this->query;
        $this->fragment = clone $this->fragment;
    }

    /**
     * Set the URL scheme component
     *
     * @param mixed $data
     *
     * @return self
     */
    public function setScheme($data)
    {
        $clone = clone $this;
        $clone->scheme->set($data);

        return $clone;
    }

    /**
     * get the URL scheme component
     *
     * @return League\Url\Components\Scheme
     */
    public function getScheme()
    {
        return clone $this->scheme;
    }

    /**
     * Set the URL user component
     *
     * @param mixed $data
     *
     * @return self
     */
    public function setUser($data)
    {
        $clone = clone $this;
        $clone->user->set($data);

        return $clone;
    }

    /**
     * get the URL pass component
     *
     * @return League\Url\Components\User
     */
    public function getUser()
    {
        return clone $this->user;
    }

    /**
     * Set the URL pass component
     *
     * @param mixed $data
     *
     * @return self
     */
    public function setPass($data)
    {
        $clone = clone $this;
        $clone->pass->set($data);

        return $clone;
    }

    /**
     * get the URL pass component
     *
     * @return League\Url\Components\Pass
     */
    public function getPass()
    {
        return clone $this->pass;
    }

    /**
     * Set the URL host component
     *
     * @param mixed $data
     *
     * @return self
     */
    public function setHost($data)
    {
        $clone = clone $this;
        $clone->host->set($data);

        return $clone;
    }

    /**
     * get the URL pass component
     *
     * @return League\Url\Components\Host
     */
    public function getHost()
    {
        return clone $this->host;
    }

    /**
     * Set the URL port component
     *
     * @param mixed $data
     *
     * @return self
     */
    public function setPort($data)
    {
        $clone = clone $this;
        $clone->port->set($data);

        return $clone;
    }

    /**
     * get the URL pass component
     *
     * @return League\Url\Components\Port
     */
    public function getPort()
    {
        return clone $this->port;
    }

    /**
     * Set the URL path component
     *
     * @param mixed $data
     *
     * @return self
     */
    public function setPath($data)
    {
        $clone = clone $this;
        $clone->path->set($data);

        return $clone;
    }

    /**
     * get the URL pass component
     *
     * @return League\Url\Components\Path
     */
    public function getPath()
    {
        return clone $this->path;
    }

    /**
     * Set the URL query component
     *
     * @param mixed $data
     *
     * @return self
     */
    public function setQuery($data)
    {
        $clone = clone $this;
        $clone->query->set($data);

        return $clone;
    }

    /**
     * get the URL pass component
     *
     * @return League\Url\Components\Query
     */
    public function getQuery()
    {
        return clone $this->query;
    }

    /**
     * Set the URL fragment component
     *
     * @param string $data
     *
     * @return self
     */
    public function setFragment($data)
    {
        $clone = clone $this;
        $clone->fragment->set($data);

        return $clone;
    }

    /**
     * get the URL pass component
     *
     * @return League\Url\Components\Fragment
     */
    public function getFragment()
    {
        return clone $this->fragment;
    }
}
