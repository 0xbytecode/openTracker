<?php
 #############################################################################
 # IMDBPHP                              (c) Giorgos Giagas & Itzchak Rehberg #
 # written by Giorgos Giagas                                                 #
 # extended & maintained by Itzchak Rehberg <izzysoft AT qumran DOT org>     #
 # http://www.izzysoft.de/                                                   #
 # ------------------------------------------------------------------------- #
 # IMDBPHP NOW PLAYING                   (c) Ricardo Silva & Itzchak Rehberg #
 # written by Ricardo Silva (banzap) <banzap@gmail.com>                      #
 # http://www.ricardosilva.pt.tl/                                            #
 # ------------------------------------------------------------------------- #
 # This program is free software; you can redistribute and/or modify it      #
 # under the terms of the GNU General Public License (see doc/LICENSE)       #
 #############################################################################
 # $Id: imdb_nowplaying.class.php 471 2011-10-11 12:16:23Z izzy $

 require_once (dirname(__FILE__)."/mdb_base.class.php");

 #=================================================[ The IMDB Person class ]===
 /** Obtain the Now Playing Movies in theaters of USA, from IMDB
  * @package openTracker
  * @class imdb_nowplaying
  * @author Ricardo Silva (banzap) <banzap@gmail.com>
  * @author Itzchak Rehberg
  * @version $Revision: 471 $ $Date: 2011-10-11 14:16:23 +0200 (Di, 11. Okt 2011) $
  */
 class imdb_nowplaying {
    var $nowplayingpage = "http://www.imdb.com/movies-in-theaters/";
    var $page = "";

    /** Constructor: Obtain the raw data from IMDB site
     * @constructor imdb_nowplaying
     */
    function __construct() {
       $req = new MDB_Request($this->nowplayingpage);
       $req->sendRequest();
       $this->page=$req->getResponseBody();
       $this->revision = preg_replace('|^.*?(\d+).*$|','$1','$Revision: 471 $');
    }

    /** Retrieve the Now Playing Movies
     * @method getNowPlayingMovies
     * @return array of IMDB IDs
     */
    function getNowPlayingMovies() {
      $matchinit = '<h1 class="header">';
      $matchend = "<!-- begin TOP_RHS -->";
      $init_pos = strpos($this->page,$matchinit);
      $end_pos = strpos($this->page,$matchend);
      //$pattern = '!href="/title/tt(\d{7})/!';
      $pattern = '!rg/in-theaters/overview-title/images/b.gif\?link=/title/tt(\d+)!';
      if ( preg_match_all($pattern, substr($this->page,$init_pos,$end_pos - $init_pos), $matches) ) {
        $res = array_values(array_unique($matches[1]));
      } else {
        $res = array();
      }
      return $res;
    }
 }
?>
