Feature: Metacafe service provider
    In order to get information from Metacafe videos
    I want to get all the information of the video

    Scenario: Get the title of the Metacafe video
        Given The url http://www.metacafe.com/watch/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry/
        When  I get the title
        Then  The result should be "Experiments with the myth busters with diet coke and mentos dry"

    Scenario: Get the duration of the Metacafe video
        Given The url http://www.metacafe.com/watch/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry/
        When  I get the duration
        Then  The result should be ""

    Scenario: Get the thumbnail of the Metacafe video
        Given The url http://www.metacafe.com/watch/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry/
        When  I get the thumbnail
        Then  The result should be "http://www.metacafe.com/thumb/476621.jpg"

    Scenario: Get the embed HTML of the Metacafe video
        Given The url http://www.metacafe.com/watch/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry/
        When  I get the embedHTML
        Then  The result should be:
        """
        <embed
         src='http://www.metacafe.com/fplayer/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry.swf'
         width='560' height='349'
         wmode='transparent'
         pluginspage='http://www.macromedia.com/go/getflashplayer'
         type='application/x-shockwave-flash'>
        </embed>
        """

    Scenario: Get the embed url of the Metacafe video
        Given The url http://www.metacafe.com/watch/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry/
        When  I get the embed url
        Then  The result should be "http://www.metacafe.com/fplayer/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry.swf"

    Scenario: Get the FLV url of the Metacafe video
        Given The url http://www.metacafe.com/watch/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry/
        When  I get the FLV url
        Then  The result should be ""

    Scenario: Get the service name of the Metacafe video
        Given The url http://www.metacafe.com/watch/476621/experiments_with_the_myth_busters_with_diet_coke_and_mentos_dry/
        When  I get the service name
        Then  The result should be "Metacafe"