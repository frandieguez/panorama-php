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
        Then The result should be like "@http://video.ted.com/assets/player/swf/EmbedPlayer\.swf\?vu=http://video.ted.com/talk/stream/2008P/Blank/BenjaminWallace_2008P-320k\.mp4&su=(.*)@"

    Scenario: Get the embed url of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the embed url
        Then The result should be like "@http://video.ted.com/assets/player/swf/EmbedPlayer\.swf\?vu=http://video.ted.com/talk/stream/2008P/Blank/BenjaminWallace_2008P-320k\.mp4&su=(.*)@"

    Scenario: Get the FLV url of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the FLV url
        Then The result should be "http://video.ted.com/talk/stream/2008P/Blank/BenjaminWallace_2008P-320k.mp4"

    Scenario: Get the service name of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the service name
        Then The result should be "Ted"