Feature: Marca service provider
    In order to get information from Marca videos
    I want to get all the information of the video

    Scenario: Get the title of the Marca video
        Given The url http://www.marca.com/tv/?v=DN23wG8c1Rj
        When I get the title
        Then The result should be "Pau entra por la puerta grande en el club de los 10.000"

    Scenario: Get the duration of the Marca video
        Given The url http://www.marca.com/tv/?v=DN23wG8c1Rj
        When I get the duration
        Then The result should be ""

    Scenario: Get the thumbnail of the Marca video
        Given The url http://www.marca.com/tv/?v=DN23wG8c1Rj
        When I get the thumbnail
        Then The result should be "http://www.marca.com/consolamultimedia/elementos/2009/01/03/306.jpg"

    Scenario: Get the embed HTML of the Marca video
        Given The url http://www.marca.com/tv/?v=DN23wG8c1Rj
        When I get the embedHTML
        Then The result should be:
        """
        <object width='560' height='349' 
        classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000'
        codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0'>
        <param name='movie' value='http://estaticos.marca.com/multimedia/reproductores/newPlayer.swf'>
        <param name='quality' value='high'>
        <param name='allowFullScreen' value='true'>
        <param name='wmode' value='transparent'>
        <param name='FlashVars' value='ba=1&amp;cvol=1&amp;bt=1&amp;lg=0&amp;width=560&amp;height=349&amp;vID=DN23wG8c1Rj'>
        <embed
        width='560' height='349'
        src='http://estaticos03.marca.com/multimedia/reproductores/newPlayer.swf'
        quality='high'
        flashvars='ba=1&amp;cvol=1&amp;bt=1&amp;lg=0&amp;vID=DN23wG8c1Rj' allowfullscreen='true'
        type='application/x-shockwave-flash'
        pluginspage='http://www.macromedia.com/go/getflashplayer'
        wmode='transparent'>
        </object>
        """

    Scenario: Get the embed url of the Marca video
        Given The url http://www.marca.com/tv/?v=DN23wG8c1Rj
        When I get the embed url
        Then The result should be "http://www.marca.com/componentes/flash/embed.swf?ba=0&cvol=1&bt=1&lg=1&vID=DN23wG8c1Rj&ba=1"

    Scenario: Get the FLV url of the Marca video
        Given The url http://www.marca.com/tv/?v=DN23wG8c1Rj
        When I get the FLV url
        Then The result should be "http://cachevideos.elmundo.es/cr4ip/ES/marca/2009/01/03/090103lakers.flv"

    Scenario: Get the service name of the Marca video
        Given The url http://www.marca.com/tv/?v=DN23wG8c1Rj
        When I get the service name
        Then The result should be "Marca"