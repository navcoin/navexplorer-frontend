const $ = require('jquery');

import anchorme from "anchorme";

class CommunityFundProposalViewPage {
    constructor()
    {
        console.log("CommunityFund Proposal View");

        let $proposalDescription = $('.proposal-description');
        $proposalDescription.html(
            anchorme($proposalDescription.html(), {
                truncate: 35,
                attributes:[
                    {
                        name:"target",
                        value:"_blank"
                    }
                ]
            })
        );
    }
}

if ($('body').is('.page-communityfund-proposal-view')) {
    new CommunityFundProposalViewPage();
}