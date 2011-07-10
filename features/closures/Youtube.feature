Feature: Youtube service provider
    In order to get information from youtube videos
    I want to get all the information of the video

    Scenario: Get the service name of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the service name
        Then The result should be "Youtube"
    
    Scenario: Get the download url of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the download url
        Then The result should be "http://www.youtube.com/v/uO3GYt47YQs?f=videos&app=youtube_gdata"
        
    Scenario: Get the embed url of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the embed url
        Then The result should be "http://www.youtube.com/v/uO3GYt47YQs?f=videos&app=youtube_gdata"
        
    Scenario: Get the embed HTML of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the embedHTML
        Then The result should be:
        """
        <object width='560' height='349'>
                            <param name='movie' value='http://www.youtube.com/v/uO3GYt47YQs?f=videos&app=youtube_gdata'>
                            <param name='allowFullScreen' value='true'>
                            <param name='allowscriptaccess' value='always'>
                            <param name='wmode' value='transparent'>
                            <embed
                                src='http://www.youtube.com/v/uO3GYt47YQs?f=videos&app=youtube_gdata' type='application/x-shockwave-flash'
                                allowscriptaccess='always' allowfullscreen='true'
                                width='560' height='349'>
                        </object>
        """
    
    
    Scenario: Get the title of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the title
        Then The result should be "Concierto Shakira Barcelona 2011 Jugadores Pique, Xavi , Villa, Pedro , Bojan, Busi"

    Scenario: Get the duration of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the duration
        Then The result should be "296"

    Scenario: Get the thumbnail of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the thumbnail
        Then The result should be "http://i.ytimg.com/vi/uO3GYt47YQs/0.jpg"  
  
    Scenario: Get the embed url of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the embed url
        Then The result should be "http://www.youtube.com/v/uO3GYt47YQs?f=videos&app=youtube_gdata"

    Scenario: Get the FLV url of the Youtube video
        Given The url http://www.youtube.com/watch?v=uO3GYt47YQs&feature=topvideos_entertainment
        When I get the FLV url
        Then The result should be "http://www.youtube.com/v/uO3GYt47YQs?f=videos&app=youtube_gdata"

  
    