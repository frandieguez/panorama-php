Feature: Dalealplay service provider
    In order to get information from Dalealplay videos
    I want to get all the information of the video

    Scenario: Get the title of the Dalealplay video
        Given The url http://www.dalealplay.com/informaciondecontenido.php?con=403408
        When I get the title
        Then The result should be "Los mejores goles del 2011 - Vídeo Online"

    Scenario: Get the duration of the Dalealplay video
        Given The url http://www.dalealplay.com/informaciondecontenido.php?con=403408
        When I get the duration
        Then The result should be ""

    Scenario: Get the thumbnail of the Dalealplay video
        Given The url http://www.dalealplay.com/informaciondecontenido.php?con=403408
        When I get the thumbnail
        Then The result should be "http://thumbs.dalealplay.com/img/dap/403408/thumb"

    Scenario: Get the embed HTML of the Dalealplay video
        Given The url http://www.dalealplay.com/informaciondecontenido.php?con=403408
        When I get the embedHTML
        Then The result should be:
        """
        <object type='application/x-shockwave-flash'
        width='560' height='349'
        data='http://c.brightcove.com/services/viewer/federated_f9/71239000001?isVid=1&isUI=1&publisherID=35140843001&playerID=71239000001&domain=embed&autoStart=false&videoId=DAP-403408'>
        <param name='quality' value='best' />
        <param name='allowfullscreen' value='true' />
        <param name='movie' value='http://c.brightcove.com/services/viewer/federated_f9/71239000001?isVid=1&isUI=1&publisherID=35140843001&playerID=71239000001&domain=embed&autoStart=false&videoId=DAP-403408' />
        </object>
        """

    Scenario: Get the embed url of the Dalealplay video
        Given The url http://www.dalealplay.com/informaciondecontenido.php?con=403408
        When I get the embed url
        Then The result should be "http://c.brightcove.com/services/viewer/federated_f9/71239000001?isVid=1&isUI=1&publisherID=35140843001&playerID=71239000001&domain=embed&autoStart=false&videoId=DAP-403408"

    Scenario: Get the FLV url of the Dalealplay video
        Given The url http://www.dalealplay.com/informaciondecontenido.php?con=403408
        When I get the FLV url
        Then The result should be ""

    Scenario: Get the service name of the Dalealplay video
        Given The url http://www.dalealplay.com/informaciondecontenido.php?con=403408
        When I get the service name
        Then The result should be "Dalealplay"
