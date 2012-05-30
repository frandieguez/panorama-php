Feature: 11870 service provider
    In order to get information from 11870 videos
    I want to get all the information of the video

    Scenario: Get the title of the 11870 video
        Given The url http://11870.com/pro/la-cabana-argentina/videos/25f8deec
        When I get the title
        Then The result should be "vÃ­deos de La CabaÃ±a Argentina"

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
        data='http://11870.com/multimedia/11870/player.swf'
        width='560' height='349'
        bgcolor='#000000'>
        <param name='movie' value='http://m2.11870.com/multimedia/11870/player.swf?file=http://m2.11870.com/multimedia/videos/22c16ba2bb50b4adfe67271f4fa8a345.mp4&image=http://m1.11870.com/multimedia/videos/vlp_22c16ba2bb50b4adfe67271f4fa8a345.jpg&logo=http://m2.11870.com/multimedia/11870/embed_watermark.png&icons=false&logo=http://m2.11870.com/multimedia/11870/embed_watermark.png' />
        <param name='allowfullscreen' value='true'>
        <param name='allowscriptaccess' value='always'>
        <param name='seamlesstabbing' value='true'>
        <param name='wmode' value='window'>
        <param name='flashvars' value='file=http://m2.11870.com/multimedia/videos/22c16ba2bb50b4adfe67271f4fa8a345.mp4&image=http://m1.11870.com/multimedia/videos/vlp_22c16ba2bb50b4adfe67271f4fa8a345.jpg&logo=http://m2.11870.com/multimedia/11870/embed_watermark.png&icons=false'>
        </object>
        """

    Scenario: Get the embed url of the 11870 video
        Given The url http://11870.com/pro/la-cabana-argentina/videos/25f8deec
        When I get the embed url
        Then The result should be like "@http://m[\d]\.11870\.com/multimedia/11870/player\.swf\?file=http://m[\d].11870.com/multimedia/videos/22c16ba2bb50b4adfe67271f4fa8a345.mp4&image=http://m[\d].11870.com/multimedia/videos/vlp_22c16ba2bb50b4adfe67271f4fa8a345.jpg&logo=http://m[\d].11870.com/multimedia/11870/embed_watermark\.png&icons=false&logo=http://m[\d]\.11870\.com/multimedia/11870/embed_watermark\.png@"

    Scenario: Get the FLV url of the 11870 video
        Given The url http://11870.com/pro/la-cabana-argentina/videos/25f8deec
        When I get the FLV url
        Then The result should be like "@http://m[\d]\.11870\.com/multimedia/videos/22c16ba2bb50b4adfe67271f4fa8a345\.mp4@"

    Scenario: Get the service name of the 11870 video
        Given The url http://11870.com/pro/la-cabana-argentina/videos/25f8deec
        When I get the service name
        Then The result should be "11870"