Feature: 11870 service provider
    In order to get information from 11870 videos
    I want to get all the information of the video

    Scenario: Get the title of the 11870 video
        Given The url http://11870.com/pro/la-cabana-argentina/videos/25f8deec
        When I get the title
        Then The result should be "vÃ­deo de La CabaÃ±a Argentina"

    Scenario: Get the duration of the 11870 video
        Given The url http://11870.com/pro/la-cabana-argentina/videos/25f8deec
        When I get the duration
        Then The result should be ""

    Scenario: Get the thumbnail of the 11870 video
        Given The url http://11870.com/pro/la-cabana-argentina/videos/25f8deec
        When I get the thumbnail
        Then The result should be "http://m1.11870.com/multimedia/videos/vlp_22c16ba2bb50b4adfe67271f4fa8a345.jpg"

    Scenario: Get the embed HTML of the 11870 video
        Given The url http://11870.com/pro/la-cabana-argentina/videos/25f8deec
        When I get the embedHTML
        Then The result should be:
        """
        <object type='application/x-shockwave-flash'
                        width='560' height='349'
                        data='http://c.brightcove.com/services/viewer/federated_f9/71239000001?isVid=1&isUI=1&publisherID=35140843001&playerID=71239000001&domain=embed&autoStart=false&videoId=DAP-403408'>
                    <param name='quality' value='best' />
                    <param name='allowfullscreen' value='true' />
                    <param name='scale' value='showAll' />
                    <param name='movie' value='{$this->getEmbedUrl()}' />
                </object>
        """

    Scenario: Get the embed url of the 11870 video
        Given The url http://11870.com/pro/la-cabana-argentina/videos/25f8deec
        When I get the embed url
        Then The result should be "http://m0.11870.com/multimedia/11870/player.swf?file=http://m0.11870.com/multimedia/videos/22c16ba2bb50b4adfe67271f4fa8a345.mp4&image=http://m1.11870.com/multimedia/videos/vlp_22c16ba2bb50b4adfe67271f4fa8a345.jpg&logo=http://m0.11870.com/multimedia/11870/embed_watermark.png&icons=false&logo=http://m0.11870.com/multimedia/11870/embed_watermark.png"

    Scenario: Get the FLV url of the 11870 video
        Given The url http://11870.com/pro/la-cabana-argentina/videos/25f8deec
        When I get the FLV url
        Then The result should be "http://m0.11870.com/multimedia/videos/22c16ba2bb50b4adfe67271f4fa8a345.mp4"

    Scenario: Get the service name of the 11870 video
        Given The url http://11870.com/pro/la-cabana-argentina/videos/25f8deec
        When I get the service name
        Then The result should be "11870"