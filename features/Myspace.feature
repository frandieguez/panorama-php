Feature: MySpace service provider
    In order to get information from MySpace videos
    I want to get all the information of the video

    Scenario: Get the title of the MySpace video
        Given The url http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=27111431
        When I get the title
        Then The result should be "rocabilis"

    Scenario: Get the duration of the MySpace video
        Given The url http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=27111431
        When I get the duration
        Then The result should be ""

    Scenario: Get the thumbnail of the MySpace video
        Given The url http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=27111431
        When I get the thumbnail
        Then The result should be "http://a1.ec-videos.myspacecdn.com/videos02/169/ca961c5911734ed29ce0764701dcf33c/thumb1.jpg"

    Scenario: Get the embed HTML of the MySpace video
        Given The url http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=27111431
        When I get the embedHTML
        Then The result should be:
        """
        <embed src='http://lads.myspace.com/videos/vplayer.swf?m=27111431&v=2&type=video'
            width='560' height='349'
            type='application/x-shockwave-flash'>
        </embed>
        """

    Scenario: Get the embed url of the MySpace video
        Given The url http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=27111431
        When I get the embed url
        Then The result should be "http://lads.myspace.com/videos/vplayer.swf?m=27111431&v=2&type=video"

    Scenario: Get the FLV url of the MySpace video
        Given The url http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=27111431
        When I get the FLV url
        Then The result should be like "@http://l.ec-videos.myspacecdn.com:80/videos02/182/f851034266294de3b1feda7de0dc1bf9/vid.flv?t=@"

    Scenario: Get the service name of the MySpace video
        Given The url http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=27111431
        When I get the service name
        Then The result should be "Myspace"