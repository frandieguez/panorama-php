Feature: Ted service provider
    In order to get information from Ted videos
    I want to get all the information of the video

    Scenario: Get the service name of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the service name
        Then The result should be "Ted"

    Scenario: Get the title of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the title
        Then The result should be "Benjamin Wallace: The price of happiness"

    Scenario: Get the duration of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the duration
        Then The result should be ""

    Scenario: Get the thumbnail of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the thumbnail
        Then The result should be like "@https://pe.tedcdn.com/images/ted/\S*\.jpg@"

    Scenario: Get the embed url of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the embed url
        Then The result should be "https://embed.ted.com/talks/benjamin_wallace_on_the_price_of_happiness"

    Scenario: Get the embed HTML of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the embedHTML
        Then The result should be "<iframe src='https://embed.ted.com/talks/benjamin_wallace_on_the_price_of_happiness' width='560' height='349' frameborder='0' scrolling='no' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>"

    Scenario: Get the FLV url of the Ted video
        Given The url http://www.ted.com/talks/benjamin_wallace_on_the_price_of_happiness.html
        When I get the FLV url
        Then The result should be ""
