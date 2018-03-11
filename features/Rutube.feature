Feature: Rutube service provider
    In order to get information from Rutube videos
    I want to get all the information of the video

    Scenario: Get the title of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the title
        Then The result should be "Фейерверк разбушевался"

    Scenario: Get the title of the Rutube video
        Given The url https://rutube.ru/video/7557315f1f4922f0caa6d4ae45b2888d/
        When I get the title
        Then The result should be "Холостяк: Интервью участниц"

    Scenario: Get the duration of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the duration
        Then The result should be ""

    Scenario: Get the thumbnail of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the thumbnail
        Then The result should be "//pic.rutube.ru/video/08/06/080693c750a84c004254b7bf1f629b55.jpg?size=l"

    Scenario: Get the embed HTML of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the embedHTML
        Then The result should be:
        """
        <iframe width="560" height="349" src="//rutube.ru/play/embed/4436308" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>
        """

    Scenario: Get the embed url of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the embed url
        Then The result should be "//rutube.ru/play/embed/4436308"

    Scenario: Get the FLV url of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the FLV url
        Then The result should be ""

    Scenario: Get the service name of the Rutube video
        Given The url http://rutube.ru/tracks/4436308.html?v=da5ede8f5aa5832e74b8afec8bd1818f
        When I get the service name
        Then The result should be "Rutube"
