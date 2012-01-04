Feature: Rutube service provider
    In order to get information from Rutube videos
    I want to get all the information of the video

    Scenario: Get the title of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the title
        Then The result should be "Фейерверк разбушевался"

    Scenario: Get the duration of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the duration
        Then The result should be ""

    Scenario: Get the thumbnail of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the thumbnail
        Then The result should be "http://img.rutube.ru/thumbs/da/5e/da5ede8f5aa5832e74b8afec8bd1818f-2.jpg"

    Scenario: Get the embed HTML of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the embedHTML
        Then The result should be:
        """
        <object width='560' height='349'>
        <param name='movie' value='http://video.rutube.ru/da5ede8f5aa5832e74b8afec8bd1818f'></param>
        <param name='wmode' value='window'></param>
        <param name='allowFullScreen' value='true'></param>
        <embed type='application/x-shockwave-flash
        src='http://video.rutube.ru/da5ede8f5aa5832e74b8afec8bd1818f'
        width='560' height='349'
        wmode='window' allowFullScreen='true'></embed>
        </object>
        """

    Scenario: Get the embed url of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the embed url
        Then The result should be "http://video.rutube.ru/da5ede8f5aa5832e74b8afec8bd1818f"

    Scenario: Get the FLV url of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the FLV url
        Then The result should be "http://bl.rutube.ru/da5ede8f5aa5832e74b8afec8bd1818f.iflv"

    Scenario: Get the service name of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the service name
        Then The result should be "Rutube"