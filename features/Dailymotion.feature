Feature: Dailymotion service provider
    In order to get information from Dailymotion videos
    I want to get all the information of the video

    Scenario: Get the title of the Dailymotion video
        Given The url https://www.dailymotion.com/video/x7mb1l2
        When  I get the title
        Then  The result should be "6 Paw Patrol Mighty Pups Play - video dailymotion"

    Scenario: Get the duration of the Dailymotion video
        Given The url https://www.dailymotion.com/video/x7mb1l2
        When  I get the duration
        Then  The result should be "252"

    Scenario: Get the thumbnail of the Dailymotion video
        Given The url https://www.dailymotion.com/video/x7mb1l2
        When  I get the thumbnail
        Then  The result should be like "@http(s)?://s[0-9]+.dmcdn.net/v/[a-z0-9]+/526x297@i"

    Scenario: Get the embed HTML of the Dailymotion video
        Given The url https://www.dailymotion.com/video/x7mb1l2
        When  I get the embedHTML
        Then  The result should be "<iframe src='https://www.dailymotion.com/embed/video/x7mb1l2' width='560' height='349' frameborder='0' title='6 Paw Patrol Mighty Pups Play - video dailymotion' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>"

    Scenario: Get the embed url of the Dailymotion video
        Given The url https://www.dailymotion.com/video/x7mb1l2
        When  I get the embed url
        Then  The result should be "https://www.dailymotion.com/embed/video/x7mb1l2"

    Scenario: Get the FLV url of the Dailymotion video
        Given The url https://www.dailymotion.com/video/x7mb1l2
        When  I get the FLV url
        Then  The result should be ""

    Scenario: Get the service name of the Dailymotion video
        Given The url https://www.dailymotion.com/video/x7mb1l2
        When  I get the service name
        Then  The result should be "Dailymotion"
