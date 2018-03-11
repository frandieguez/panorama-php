Feature: Youtube service provider
    In order to get information from youtube videos
    I want to get all the information of the video

    Scenario: Get the title of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the title
        Then The result should be "Concierto Shakira Barcelona 2011 Jugadores Pique, Xavi , Villa, Pedro , Bojan, Busi"

    Scenario: Get the duration of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the duration
        Then The result should be "0"

    Scenario: Get the thumbnail of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the thumbnail
        Then The result should be like "@//(.*).ytimg.com/vi/uO3GYt47YQs/hqdefault.jpg@"

    Scenario: Get the embed HTML of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the embedHTML
        Then The result should be "<iframe type='text/html' src='https://www.youtube.com/embed/uO3GYt47YQs?feature=oembed' width='560' height='349' frameborder='0' allowfullscreen='true'></iframe>"

    Scenario: Get the embed url of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the embed url
        Then The result should be "https://www.youtube.com/embed/uO3GYt47YQs?feature=oembed"

    Scenario: Get the download url of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the download url
        Then The result should be ""

    Scenario: Get the FLV url of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the FLV url
        Then The result should be ""

    Scenario: Get the service name of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the service name
        Then The result should be "Youtube"
