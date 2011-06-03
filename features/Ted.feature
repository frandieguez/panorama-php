Feature: Vimeo service provider
    In order to get information from Vimeo videos
    I want to get all the information of the video

        
    
    #Scenario: Get the download url of the Vimeo video
    #    Given The url http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html
    #    When I get the download url
    #    Then The result should be "http://www.youtube.com/v/uO3GYt47YQs?f=videos&app=youtube_gdata"
    
    Scenario: Get the embed url of the Vimeo video
        Given The url http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the embed url
        Then The result should be "http://vimeo.com/moogaloop.swf?clip_id=5362441&server=vimeo.com&fullscreen=1&show_title=1&show_byline=1&show_portrait=1"

    Scenario: Get the embed HTML of the Vimeo video
        Given The url http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the embedHTML
        Then The result should be:
        """
        <object width='560' height='349'>
                                <param name='movie' value='http://vimeo.com/moogaloop.swf?clip_id=5362441&server=vimeo.com&fullscreen=1&show_title=1&show_byline=1&show_portrait=1'></param>
                                <param name='allowFullScreen' value='true'></param>
                                <param name='allowscriptaccess' value='always'></param>
                                <param name='wmode' value='transparent'></param>
                                <embed
                                    src='http://vimeo.com/moogaloop.swf?clip_id=5362441&server=vimeo.com&fullscreen=1&show_title=1&show_byline=1&show_portrait=1' type='application/x-shockwave-flash'
                                    allowscriptaccess='always' allowfullscreen='true'
                                    width='560' height='349'>
                                </embed>
                            </object>
        """
    
    Scenario: Get the title of the Vimeo video
        Given The url http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the title
        Then The result should be "A blog in 15 minutes with Ruby on Rails"

    Scenario: Get the duration of the Vimeo video
        Given The url http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the duration
        Then The result should be "569"

    Scenario: Get the thumbnail of the Vimeo video
        Given The url http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the thumbnail
        Then The result should be "http://b.vimeocdn.com/ts/172/454/17245493_640.jpg"  

    Scenario: Get the embed url of the Vimeo video
        Given The url http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the embed url
        Then The result should be "http://vimeo.com/moogaloop.swf?clip_id=5362441&server=vimeo.com&fullscreen=1&show_title=1&show_byline=1&show_portrait=1"
    
    Scenario: Get the FLV url of the Vimeo video
        Given The url http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the FLV url
        Then The result should be "http://www.youtube.com/v/uO3GYt47YQs?f=videos&app=youtube_gdata"

    Scenario: Get the service name of the Vimeo video
        Given The url http://www.ted.com/index.php/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the service name
        Then The result should be "Vimeo"