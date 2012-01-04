Feature: Ted service provider
    In order to get information from Ted videos
    I want to get all the information of the video

    Scenario: Get the title of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the title
        Then The result should be "Benjamin Wallace on the price of happiness"

    Scenario: Get the duration of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the duration
        Then The result should be ""

    Scenario: Get the thumbnail of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the thumbnail
        Then The result should be "http://images.ted.com/images/ted/tedindex/embed-posters/BenjaminWallace-2008P.embed_thumbnail.jpg"

    Scenario: Get the embed HTML of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the embedHTML
        Then The result should be:
        """
        <object width='560' height='349'>
        <param name='movie' value='http://video.ted.com/assets/player/swf/EmbedPlayer.swf?vu=http://video.ted.com/talk/stream/2008P/Blank/BenjaminWallace_2008P-320k.mp4&su=http://images.ted.com/images/ted/tedindex/embed-posters/BenjaminWallace-2008P.embed_thumbnail.jpg&vw=384&vh=288&ap=0&ti=419&lang=en&introDuration=15330&adDuration=4000&postAdDuration=830&adKeys=talk=benjamin_wallace_on_the_price_of_happiness;year=2008;theme=food_matters;theme=unconventional_explanations;theme=master_storytellers;theme=how_the_mind_works;event=Taste3 2008;tag=Business;tag=Culture;tag=Entertainment;tag=book;tag=food;tag=happiness;tag=writing;&preAdTag=tconf.ted/embed;tile=1;sz=512x288;'></param>
        <param name='allowFullScreen' value='true'></param>
        <param name='wmode' value='transparent'></param>
        <param name='bgColor' value='#ffffff'></param>
        <embed pluginspace='http://www.macromedia.com/go/getflashplayer
        type='application/x-shockwave-flash'
        wmode='transparent' allowFullScreen='true' bgColor='#ffffff'
        src='http://video.ted.com/assets/player/swf/EmbedPlayer.swf?vu=http://video.ted.com/talk/stream/2008P/Blank/BenjaminWallace_2008P-320k.mp4&su=http://images.ted.com/images/ted/tedindex/embed-posters/BenjaminWallace-2008P.embed_thumbnail.jpg&vw=384&vh=288&ap=0&ti=419&lang=en&introDuration=15330&adDuration=4000&postAdDuration=830&adKeys=talk=benjamin_wallace_on_the_price_of_happiness;year=2008;theme=food_matters;theme=unconventional_explanations;theme=master_storytellers;theme=how_the_mind_works;event=Taste3 2008;tag=Business;tag=Culture;tag=Entertainment;tag=book;tag=food;tag=happiness;tag=writing;&preAdTag=tconf.ted/embed;tile=1;sz=512x288;'
        width='560' height='349'></embed>
        </object>
        """

    Scenario: Get the embed url of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the embed url
        Then The result should be "http://video.ted.com/assets/player/swf/EmbedPlayer.swf?vu=http://video.ted.com/talk/stream/2008P/Blank/BenjaminWallace_2008P-320k.mp4&su=http://images.ted.com/images/ted/tedindex/embed-posters/BenjaminWallace-2008P.embed_thumbnail.jpg&vw=384&vh=288&ap=0&ti=419&lang=en&introDuration=15330&adDuration=4000&postAdDuration=830&adKeys=talk=benjamin_wallace_on_the_price_of_happiness;year=2008;theme=food_matters;theme=unconventional_explanations;theme=master_storytellers;theme=how_the_mind_works;event=Taste3 2008;tag=Business;tag=Culture;tag=Entertainment;tag=book;tag=food;tag=happiness;tag=writing;&preAdTag=tconf.ted/embed;tile=1;sz=512x288;"

    Scenario: Get the FLV url of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the FLV url
        Then The result should be "http://video.ted.com/talk/stream/2008P/Blank/BenjaminWallace_2008P-320k.mp4"

    Scenario: Get the service name of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the service name
        Then The result should be "Ted"