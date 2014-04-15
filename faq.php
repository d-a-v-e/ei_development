<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>

<!-- Page content -->
<div id="page-content">
    <!-- FAQ Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="fa fa-info"></i>Useful Information<br><small></small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="index.php">Home</a></li>
        <li>Useful Information</li>
    </ul>
    <!-- END FAQ Header -->

    <!-- FAQ Block -->
    <div class="block block-alt-noborder">
        <!-- FAQ Content -->
        <div class="row">
            
            <div class="col-md-12 col-lg-10 col-lg-offset-1">
                <!-- Intro Content -->
                <h3 class="sub-header"><strong>How It Works</strong></h3>
                <div id="faq1" class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q1">Intro</a></h4>
                        </div>
                        <div id="faq1_q1" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <p>Entertainment Intelligence Tour Planning (EITP) is a collaborative environment designed to help any company or individual with the complex and time consuming process of planning medium to large, national and international, recurring or one off, tours, festivals and events. The best way to visualise EITP is to think of LinkedIn meets Basecamp meets Salesforce.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q2">Campaigns</a></h4>
                        </div>
                        <div id="faq1_q2" class="panel-collapse collapse">
                            <div class="panel-body"><p>The term campaign is our way of referring to a collection of related events like dates on a live music tour, presentations at a trade show or slots on stages at a festival. The layout and requirements of the campaign will change according to the type of template selected, a single artist European tour obviously needing different information and processes to a six stage festival lineup.</p></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q3">Requirements</a></h4>
                        </div>
                        <div id="faq1_q3" class="panel-collapse collapse">
                            <div class="panel-body"><p>As the name suggested the campaign needs to have a set of requirements loaded that define the structure and expectations of the project, such as target start and end dates, average face value, region, rider etc. These form the summary that will be included in any Requests To Tender that are sent out to suppliers (more on that later).</p></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q4">Invitations</a></h4>
                        </div>
                        <div id="faq1_q4" class="panel-collapse collapse">
                            <div class="panel-body"><p>Once a campaign owner, for instance the booking agent, has created the campaign and agreed the requirements with the requester, usually the Artist Manager/Label or Event Owner, they can send them an invite to review their submissions and monitor progress. The campaign owner can also invite others in their team, reps, or anyone else that needs to have “top level” access to this project.</p>
                            <p><small>*Keep in mind that all other invitations will be handled as part of the planning process, so should not be done at the campaign (top) level.</small></p></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q5">Routing</a></h4>
                        </div>
                        <div id="faq1_q5" class="panel-collapse collapse">
                            <div class="panel-body"><p>For a Touring campaign there is the option to add Dates, which at the beginning of the planning process only relate to the Locations on the tour that the artist would prefer to play and any flexibility around those dates.</p>
                            <p>Towns and Countries are pulled from a large database that also contains their geo locations, which means we can generate a handy route map of your tour.</p>
                            <p><small>*The Venue to be played is selected based on feedback and availability provided by the Promoter later in the process, though preferences can be declared as part of the Request To Tender of course.</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q6">Stages</a></h4>
                        </div>
                        <div id="faq1_q6" class="panel-collapse collapse">
                            <div class="panel-body"><p>Unlike a touring campaign a Programme campaign has an option for creating multiple Stages that have Slots into which Line-Up (artist, speakers, films) is scheduled.</p>
                            <p>Each stage on a programme can have different supplier requirements too, like power, noise limit, audio equipment, set changes etc.</p>
                            <p>Slots can be Multi Line-Up (four speakers on a panel discussion) or Single Line-Up (bands playing 20 min slots on an acoustic stage). You can set Change Over times, Clash Limits (how much time before someone can appear here again or on a different stage) and Curfews (so the show doesn’t overrun its license).</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q7">Invitations</a></h4>
                        </div>
                        <div id="faq1_q7" class="panel-collapse collapse">
                            <div class="panel-body"><p>In order to be a flexible yet accurate planning tool EITP offers a facility for uploading documents that help with the delivery of the campaign. This can be anything from an excel sheet of possible tour dates and preferred venues, artist pack shots and logos for inclusion in store builds or digital music samples that retailers use to promote a new album. The advantage being that everything is stored in one place so no one has an excuse for using the wrong assets or information.</p><p>At this stage there is no option to read imported files and use their data to generate content or populate sections of the system, but this may change in the near future.</p></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q8">Request To Tender - Touring</a></h4>
                        </div>
                        <div id="faq1_q8" class="panel-collapse collapse">
                            <div class="panel-body"><p>Now that the campaign requirements, routing or stages and attachments have been added the fine details of the plan can be addressed.</p></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q9">Promoters</a></h4>
                        </div>
                        <div id="faq1_q9" class="panel-collapse collapse">
                            <div class="panel-body"><p>At the bottom of the Routing screen the campaign organiser selects Invite Promoters, searches for promoters (adds if they don’t exist) and assigns them to the tour. *Promoter information should be accurate, as it will be used again.</p><p>Against each promoter Dates (Locations) are ticked to denote who will receive an email with a summary of the campaign and events to quote on.</p><p><small>*Promoters will only have visibility of the dates assigned to them and multiple promoters can be asked to bid on each date (they wont see each others bids), the final selection being down to the campaign organiser.</small></p></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q10">Ticket Sellers</a></h4>
                        </div>
                        <div id="faq1_q10" class="panel-collapse collapse">
                            <div class="panel-body"><p>Once the booking agent has selected their preferred promoter/venue for each date on the tour they can push out the confirmations via the same system.</p>
                            <p>The venue or promoter (dependent on preference) can then split out the allocations for the show and pass these to the Ticket Sellers in the form of a preformatted email, including tour requirements and assets (band logo etc.) that are relevant.</p>
                            <p>It is hoped that the control of ticket allocations via EITP will eventually become the norm as it will help all parties spot mistakes, monitor progress and reallocate according to demand. Plus there is an audit trail (see Updates) of all actions taken.</p></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q11">Request To Tender - Programme</a></h4>
                        </div>
                        <div id="faq1_q11" class="panel-collapse collapse">
                            <div class="panel-body"><p>Unlike a touring campaign, a Programme campaign will involve a Stage Manager requesting availability and price from Booking Agents for their Talent or Content (films for instance) and then fitting those into Slots. The invite and response process is the same, it is just the format and information requested that will differ along with the change in levels i.e. the Booking Agent is working below the Event Organiser / Promoter / Stage Manager in this case.</p></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q12">Updates</a></h4>
                        </div>
                        <div id="faq1_q12" class="panel-collapse collapse">
                            <div class="panel-body"><p>All additions and changes to a campaign are recorded and displayed in the Updates section. This helps spot hold ups, changes etc. and pushes people to keep on top of their tasks. It would be possible to issue alerts for campaigns where an update/response had not been received in a defined period of time.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq1" href="#faq1_q13">Discussions</a></h4>
                        </div>
                        <div id="faq1_q13" class="panel-collapse collapse">
                            <div class="panel-body"><p>As the name suggests, Discussions are open conversations around a certain subject, relating to the campaign they are linked to. A list of participants can be defined and notified each time a comment or question is posted or they can contribute whenever they see a topic on the discussion board that they have a helpful answer to. The idea is to create a collaborative and valued community for the industry through open dialogue.</p></div>
                        </div>
                    </div>
                </div>
                <!-- END Intro Content -->

                <!-- Features Content -->
                <h3 class="sub-header"><strong>Terms and Conditions</strong></h3>
                <div id="faq2" class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq2" href="#faq2_q1">T&C</a></h4>
                        </div>
                        <div id="faq2_q1" class="panel-collapse collapse">
                            <div class="panel-body"><p>The Entertainment Intelligence Tour Planning (EITP) service is free to join and use for the planning, collecting and sharing of live event information. The more the platform is used and others encouraged to join, the more effective and valuable it will become to everyone involved.</p>

<p>As with any socially connected network, the effectiveness of this service will always be determined by the quality of the data submitted and care and consideration of its participants. With this in mind, we ask that you take time to submit as accurate and detailed information as possible and notify us of any inaccuracies, corrections or abuse of the service at <a href="mailto:support@entertainment-intelligence.com">support@entertainment-intelligence.com.</a></p>

<p>Please be aware that EITP is designed, developed and funded by the Entertainment Intelligence Steering Group, a collection of industry experts with a passion for improving the effectiveness and profitability of the industry as a whole. As the solution evolves there will be complimentary services added, such as data analysis, that participants can pay to access and thus help fund future innovations, but the core solution will remain free to use. Entertainment Intelligence can also undertake bespoke developments and commissions, either for private use or modules that will benefit all. For more information about our current technical roadmap or to request a quote please contact us at <a href="mailto:info@entertainment-intelligence.com">info@entertainment-intelligence.com.</a></p>

<p>We thank you for your encouragement, feedback and support,</p>

<p>The Team at Entertainment Intelligence</p>
</div>
                        </div>
                    </div>
                </div>
                <!-- END Features Content -->

                <!-- Subscriptions Content -->
                <h3 class="sub-header"><strong>Privacy</strong></h3>
                <div id="faq3" class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq3" href="#faq3_q1">Privacy Policy</a></h4>
                        </div>
                        <div id="faq3_q1" class="panel-collapse collapse">
                            <div class="panel-body"><p>Entertainment Intelligence Tour Planning (EITP) service is an industry specific platform that is not aimed at the general public, but as a socially connected network there needs to be a level of trust and openness in order to make it effective. When you create a new campaign it will only be visible to those you invite to contribute to it, at the level they are invited and those that they invite to contribute, at a lower level of course.</p>

<p>We ask that you do not submit private contact details to the platform if you do not want participants to direct requests and responses to those addresses. We also ask that you respect other privacy and do not pass on contact details to anyone not registered on the platform, if they need to have access you should invite them or encourage someone at a different level to do so if appropriate.</p>

<p>Entertainment Intelligence will not share your contact information with anyone outside of the EITP family and will not sell information to mailing lists or advertisers. From time to time we may introduce vetted suppliers and recommend services that the steering group consider beneficial to the industry, but you do have the option to unsubscribe from these messages if you so wish.</p>

<p>If you have any questions about your privacy or other aspects of the system please contact us at <a href="mailto:support@entertainment-intelligence.com">support@entertainment-intelligence.com</a></p>
</div>
                        </div>
                    </div>
                </div>
                <!-- END Subscriptions Content -->
            </div>
        </div>
        <!-- END FAQ Content -->
    </div>
    <!-- END FAQ Block -->
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>
<?php include 'inc/template_end.php'; ?>