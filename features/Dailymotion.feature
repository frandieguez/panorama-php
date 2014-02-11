Feature: Dailymotion service provider
    In order to get information from Dailymotion videos
    I want to get all the information of the video

    Scenario: Get the title of the Dailymotion video
        Given The url http://www.dailymotion.com/visited-week/lang/es/video/x7u5kn_parkour-dayyy_sport
        When  I get the title
        Then  The result should be "parkour dayyy"

    Scenario: Get the duration of the Dailymotion video
        Given The url http://www.dailymotion.com/visited-week/lang/es/video/x7u5kn_parkour-dayyy_sport
        When  I get the duration
        Then  The result should be ""

    Scenario: Get the thumbnail of the Dailymotion video
        Given The url http://www.dailymotion.com/visited-week/lang/es/video/x7u5kn_parkour-dayyy_sport
        When  I get the thumbnail
        Then  The result should be "http://s1.dmcdn.net/resw/x240-_VO.jpg"

    Scenario: Get the embed HTML of the Dailymotion video
        Given The url http://www.dailymotion.com/visited-week/lang/es/video/x7u5kn_parkour-dayyy_sport
        When  I get the embedHTML
        Then  The result should be:
        """
        <object width='560' height='349'>
        <param name='movie' value='http://www.dailymotion.com/swf/video/x7u5kn&related=1'></param>
        <param name='allowFullScreen' value='true'></param>
        <param name='allowScriptAccess' value='always'></param>
        <embed type='application/x-shockwave-flash'
        src='http://www.dailymotion.com/swf/video/x7u5kn&related=1'
        width='560' height='349'
        allowFullScreen='true' allowScriptAccess='always'>
        </embed>
        </object>
        """

    Scenario: Get the embed url of the Dailymotion video
        Given The url http://www.dailymotion.com/visited-week/lang/es/video/x7u5kn_parkour-dayyy_sport
        When  I get the embed url
        Then  The result should be "http://www.dailymotion.com/swf/video/x7u5kn"

    Scenario: Get the FLV url of the Dailymotion video
        Given The url http://www.dailymotion.com/visited-week/lang/es/video/x7u5kn_parkour-dayyy_sport
        When  I get the FLV url
        Then  The result should be "http://www.dailymotion.com/embed/video/x7u5kn"

    Scenario: Get the service name of the Dailymotion video
        Given The url http://www.dailymotion.com/visited-week/lang/es/video/x7u5kn_parkour-dayyy_sport
        When  I get the service name
        Then  The result should be "Dailymotion"
