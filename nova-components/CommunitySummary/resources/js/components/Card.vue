<template>
    <div class="mt-12">
        <div :loading="!loaded" class="customSummary">
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i" rel="stylesheet">
            <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

            <h5 style="font-size: 15px;color: rgb(156, 155, 155);width: 100%;text-align: right;">{{size}} | {{this.community ? (this.community.housing_data ?
                            this.community.housing_data.housing_units : '') : ''}} Housing Units
                <span><div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" @click="csInfoToggleClick()" style="cursor:pointer;color:#0a4c9e"></div></span>
            </h5>
            <div class="summary customHeader">
                <div class="custHeadTop">
                    <div class="customHeadLeft">
                        <img v-if="this.community ? this.community.community_logo : null" :src="logoUrl" class="logoCommunity" alt="Logo of Community">
                        <div v-if="this.community ? !this.community.community_logo : null" class="blank-image"></div>
                        <div class="titleHeadings">
                            <h1 class="headline">{{this.communityName}}</h1><br>
                            <h4><strong style="font-size: 13px;color: #9c9b9b;padding-left: 11px;"><span> RM | Not Assigned</span> <span> ID: {{this.community? this.community.COMMUNITYID : null }}</span> </strong></h4>
                        </div>
                    </div>
                    <div class="customHeadRight" style="text-align:center">
                        <div class="wrap-programs">
                            <div class="programsCustom customBorder">
                                <h3 class="text-center">FCL<br>
                                    <!-- <span class="text-xs text-80">{{parseInt(estForeclosures).toLocaleString()}}</span> -->
                                </h3>
                                <div v-html="foreclosureBadgeContent"
                                    :class="this.foreclosurePartner ? 'round-info-green gold-n5' : 'round-info gold-n0'"></div>
                            </div>
                            <div class="programsCustom customBorder">
                                <h3 class="text-center">VPO<br>
                                    <!-- <span class="text-xs text-80">{{this.community ? (this.community.housing_data ? parseInt(this.community.housing_data.est_vacant_total).toLocaleString() : 0) : 0}}</span> -->
                                </h3>
                                <div v-html="vacantBadgeContent"
                                    :class="this.vacantPartner ? 'round-info-green gold-n5' : 'round-info gold-n0'"></div>
                            </div>
                            <div class="programsCustom customBorder">
                                <h3 >LTR<br>
                                    <!-- <span class="text-xs text-80">{{this.community ? (this.community.housing_data ? parseInt(this.community.housing_data.est_long_term_rental).toLocaleString() : 0) : 0}}</span> -->
                                </h3>
                                <div v-html="rentalBadgeContent"
                                    :class="this.rentalPartner ? 'round-info-green gold-n5' : 'round-info gold-n0'"></div>
                            </div>
                            <div class="programsCustom">
                                <h3 >STR<br>
                                    <!-- <span class="text-xs text-80">0.00</span> -->
                                </h3>
                                <div 
                                    :class="this.rentalPartner ? 'round-info gold-n0' : 'round-info gold-n0'"></div>
                            </div>
                        </div>
                        <h4 class="infoCustomText" style="color: #9c9b9b;">Contract<span v-html="contractExpiration"></span></h4>
                    </div>
                </div>
                <div class="cityCounty">
                    <div class="cardHolder">
                        <div class="card cardCustom" style="margin: 0px 0px;">
                            <div class="cardCustomHeader">
                                <h4 class="countyCityCardHeading"><span>City of Jacksonvill</span></h4>
                            </div>
                            <div class="cardCustomBody">
                                <div class="cardBodyList">
                                    <button @click="displayLink" class="btn btn-default btn-outline cardBodyListBtn">Landing Page</button>
                                </div>
                                <div class="cardBodyList">
                                    <button class="btn btn-default btn-outline cardBodyListBtn">GOV Admin</button>
                                </div>
                                <div class="cardBodyList">
                                    <button @click="viewCore" class="btn btn-default btn-outline cardBodyListBtn">Core</button>
                                </div>
                                <div class="cardBodyList">
                                    <button @click="viewSharepoint" class="btn btn-default btn-outline cardBodyListBtn">Sharepoint</button>
                                </div>
                                <p class="cardBodyBottomText"><a href="">Adjucent Community List</a></p>
                            </div>
                        </div>
                        <div class="card cardCustom" style="margin: 0px -1px;">
                            <div class="cardCustomHeader">
                                <h4 class="countyCityCardHeading"><span>Duval County</span></h4>
                            </div>
                            <div class="cardCustomBody">
                                <div class="cardBodyList">
                                    <button class="btn btn-default btn-outline cardBodyListBtn">Country Clerk</button>
                                </div>
                                <div class="cardBodyList">
                                    <button class="btn btn-default btn-outline cardBodyListBtn">Property Appriser</button>
                                </div>
                                <div class="cardBodyList">
                                    <button class="btn btn-default btn-outline cardBodyListBtn">Tax Accessor</button>
                                </div>
                                <div class="cardBodyList">
                                    <button class="btn btn-default btn-outline cardBodyListBtn">Court Docket</button>
                                </div>
                                <p class="cardBodyBottomText"><a href="">County List</a></p>
                            </div>
                        </div>
                        <div class="card cardCustom" style="margin: 0px -1px;">
                            <div class="cardCustomHeader">
                                <h4 class="countyCityCardHeading"><span>Florida</span></h4>
                            </div>
                            <div class="cardCustomBody">
                                <div class="cardBodyList">
                                    <p class="cardBodyListText">Governance</p>
                                    <button class="btn btn-default btn-outline cardBodyListBtn">Home Rule</button>
                                </div>
                                <div class="cardBodyList">
                                    <p class="cardBodyListText">FC Process</p>
                                    <button class="btn btn-default btn-outline cardBodyListBtn">Judicial</button>
                                </div>
                                <div class="cardBodyList">
                                    <p class="cardBodyListText">Exclude/Concert</p>
                                    <button class="btn btn-default btn-outline cardBodyListBtn">No</button>
                                </div>
                                <p class="cardBodyBottomText"><a href="">State List</a></p>
                            </div>
                        </div>
                        <div class="card cardCustom" style="margin: 0px -1px;">
                            <div class="cardCustomHeader">
                                <div class="cardCustomHeaderArrow"><span class="fa-xs fas fa-sort-down rotate" @click="countyCityToggle()"></span></div>
                            </div>
                            <div class="cardCustomBody" style="background-color: white;">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="communityWarning" style="display: flex">
                <div style="width:100%">
                    <i class="fa-xs fas fa-exclamation-triangle exclamation-triangle" style="margin-right:10px;font-size: 30px;"></i> Some issue or alert message can go here.
                </div>
                <div style="width:30px">
                    <i class="fa-xs fas fa-times-circle times-circle" @click="closeAlertMessage()"></i>
                </div>
            </div>
            <section class="tabSection" id="csInfoToggle">
                <div class="tabsContainer" style="display: flex;margin-top:20px">
                    <div class="tabs" style="width:100%">
                        <span class="tabCustom" id="salesTab" @click="openTabContent('salesTabContent', 'salesTab')">Sales</span>
                        <span class="tabCustom" id="serviceTab" @click="openTabContent('serviceTabContent', 'serviceTab')">Service</span>
                        <span class="tabCustom" id="legalTab" @click="openTabContent('legalTabContent', 'legalTab')">Legal</span>
                        <span class="tabCustom" id="contactTab" @click="openTabContent('contactTabContent', 'contactTab')">Contact</span>
                    </div>
                    <div class="tabs" style="width:190px">
                        <span class="tabCustom tabCustomClicked" id="tasksTab" @click="openTabContent('tasksTabContent', 'tasksTab')">Tasks <div class="taskTabNot">2</div></span>
                        <span class="tabCustom" id="actionTab" @click="openTabContent('actionTabContent', 'actionTab')">Admin <div class="taskTabNot">2</div></span>
                    </div>
                </div>
                <div class="summary" style="padding: 30px 20px;box-shadow:unset;border: 2px solid #908f8f;min-height: 150px;">
                    <div class="tabContent" id="salesTabContent">
                        <div class="wrap-detailBox">
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('coka')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square" style="padding-right: 10px;"></i>AT-Risk Property Analysis</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="cokaInfo" style="display:none">
                                    <div class="atRiskHeader">
                                        <span>Estimated Annual Registration</span>
                                        <div style="position: absolute;top: 0px;right: 0px;">
                                            <button type="button" class="btn btn-sm btn-outline">Map</button>
                                            <button type="button" class="btn btn-sm btn-outline">Print</button>
                                        </div>
                                    </div>
                                    <div class="cardHolder">
                                        <div class="card cardCustom cardCustomH">
                                            <div class="cardCustomHeader" style="background-color: #22292f;color: white;">
                                                <h4 style="width:56%;display: inline-block;">Short Term Rental</h4>
                                                <h4 style="width:40%;display: inline-block;text-align: right;">STR</h4>
                                            </div>
                                            <h4 style="margin: 10px 0px;width:100%;text-align:center;border-bottom: 2px solid;padding: 10px;">1200</h4>

                                            <div class="cardCustomHeader" style="padding: 10px 10px;">
                                                <div style="width:56%;display: inline-block;">
                                                    Listing Estimate 
                                                </div>
                                                <div style="width:40%;display: inline-block;text-align: right;">
                                                    <input type="text" style="width:70%; border:1px solid">
                                                </div>
                                                <div style="width:56%;">
                                                    <small>(Based on Regional Average of 2% of households)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card cardCustom cardCustomH">
                                            <div class="cardCustomHeader" style="background-color: #22292f;color: white;">
                                                <h4 style="width:56%;display: inline-block;">Long Term Rental</h4>
                                                <h4 style="width:40%;display: inline-block;text-align: right;">STR</h4>
                                            </div>
                                            <h4 style="margin: 10px 0px;width:100%;text-align:center;border-bottom: 2px solid;padding: 10px;">3500</h4>
                                            <div class="cardCustomHeader" style="padding: 10px 10px;">
                                                <div style="width:56%;display: inline-block;">
                                                    Census Estimate
                                                </div>
                                                <div style="width:40%;display: inline-block;text-align: right;">
                                                    <input type="text" style="width:70%; border:1px solid">
                                                </div>
                                            </div>
                                            <div class="cardCustomHeader" style="padding: 10px 10px;">
                                                <div style="width:56%;display: inline-block;">
                                                    Currently NOO
                                                    <br> (Not Owner Occupied)
                                                </div>
                                                <div style="width:40%;display: inline-block;text-align: right;">
                                                    <input type="text" style="width:70%; border:1px solid">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card cardCustom cardCustomH">
                                            <div class="cardCustomHeader" style="background-color: #22292f;color: white;">
                                                <h4 style="width:56%;display: inline-block;">Foreclosure</h4>
                                                <h4 style="width:40%;display: inline-block;text-align: right;">STR</h4>
                                            </div>
                                            <h4 style="margin: 10px 0px;width:100%;text-align:center;border-bottom: 2px solid;padding: 10px;">550</h4>
                                            <div class="cardCustomHeader" style="padding: 10px 10px;">
                                                <div style="width:56%;display: inline-block;">
                                                    Currently Active
                                                </div>
                                                <div style="width:40%;display: inline-block;text-align: right;">
                                                    <input type="text" style="width:70%; border:1px solid">
                                                </div>
                                            </div>
                                            <div class="cardCustomHeader" style="padding: 10px 10px;">
                                                <div style="width:56%;display: inline-block;">
                                                    New Foreclosure Status
                                                    <br>
                                                    (Last 12 Month)
                                                </div>
                                                <div style="width:40%;display: inline-block;text-align: right;">
                                                    <input type="text" style="width:70%; border:1px solid">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card cardCustom cardCustomH">
                                            <div class="cardCustomHeader" style="background-color: #22292f;color: white;">
                                                <h4 style="width:56%;display: inline-block;">Vacant Private Owner</h4>
                                                <h4 style="width:40%;display: inline-block;text-align: right;">STR</h4>
                                            </div>
                                            <h4 style="margin: 10px 0px;width:100%;text-align:center;border-bottom: 2px solid;padding: 10px;">2300</h4>
                                            <div class="cardCustomHeader" style="padding: 10px 10px;">
                                                <div style="width:56%;display: inline-block;">
                                                    Census Estimate
                                                </div>
                                                <div style="width:40%;display: inline-block;text-align: right;">
                                                    <input type="text" style="width:70%; border:1px solid">
                                                </div>
                                            </div>
                                            <div class="cardCustomHeader" style="padding: 10px 10px;">
                                                <div style="width:56%;display: inline-block;">
                                                    USPS Vacant
                                                </div>
                                                <div style="width:40%;display: inline-block;text-align: right;">
                                                    <input type="text" style="width:70%; border:1px solid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 style="width:100%;text-align: center;padding-top: 15px;">
                                        *The estimated annual registration are bsed on best practice ordinance and colaborative enforcement and ##% compliance.
                                    </h4>
                                    
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('tyks')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>Sales Cycle</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="tyksInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('flkr')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>Relationship Manager</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="flkrInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('tlks')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>Sales Configuration</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="tlksInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabContent" id="serviceTabContent" style="max-width: 1000px;margin: 0px auto;">
                        <div class="wrap-detailBox">
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('cok')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square" style="padding-right: 10px;"></i>Key Metrick</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="cokInfo" style="display:none">
                                    <span class="blockSpan">Active OTR's</span>
                                    <span class="blockSpan">Ended OTR's (Balance Due)</span>
                                    <span class="blockSpan">Monthly</span>
                                    <div class="monthlyList px-4">
                                        <span class="blockSpan">Payments</span>
                                        <span class="blockSpan">Deregistrations</span>
                                        <span class="blockSpan">Violations</span>
                                        <span class="blockSpan">Inspections</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('tyk')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>Remitance</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="tykInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('flk')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>Branding</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="flkInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('tlk')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>Miscellaneous</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="tlkInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabContent" id="legalTabContent" style="max-width: 1000px;margin: 0px auto;">
                        <div class="wrap-detailBox">
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('coc')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square" style="padding-right: 10px;"></i>Contracts</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="cocInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('tyc')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>Ordinance History</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="tycInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('flc')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>Key Policy</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="flcInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabContent" id="contactTabContent" style="max-width: 1000px;margin: 0px auto;">
                        <div class="wrap-detailBox">
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('coi')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square" style="padding-right: 10px;"></i>Interactions</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="coiInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('tyi')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>People</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="tyiInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('fli')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>Key Roles</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="fliInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabContent tabContentTasks" id="tasksTabContent" style="display:block;padding:0px">
                        <div class="w-full flex items-center" style="padding: 10px;">
                            <h1 class="flex-no-shrink text-90 font-normal text-2xl"></h1>
                            <div class="flex-no-shrink ml-auto">
                                <a href="javascript:void(0)" v-if="!asanaLoading" @click="createProject" class="btn btn-default btn-primary" dusk="create-button" style="border-radius: 0px;">
                                    <span id="cpLoading" style="display:none"><i class="fas fa-spinner fa-spin"></i></span>
                                    <span>Create Project</span>
                                </a>
                                <a href="javascript:void(0)" v-if="asana.length > 0 && asana.length < 2" @click="storeNewTemplateProject" class="btn btn-default btn-primary" dusk="create-button" style="border-radius: 0px;">
                                    <span id="copLoading" style="display:none"><i class="fas fa-spinner fa-spin"></i></span>
                                    <span>Create Onboarding Project</span>
                                </a>
                            </div>
                        </div>
                        <div class="tabs taskTabTabs" style="width:100%">
                            <div  v-for="(asan, index) in asana" :key="asan.gid" v-bind:class="[(index == 0) ? 'taskTabClicked' : '', 'taskTabCustom']" :id="'blC'+asan.gid" @click="openTaskTabContent('tab'+asan.gid, 'blC'+asan.gid)">
                                {{asan.name}}
                            </div>
                        </div>
                        <div class="taskTabContentContainer main-wrapper">
                            <div v-for="asan in asana" :key="asan.gid" class="taskTabContent" :id="`tab${asan.gid}`" style="min-height: 600px;background-color: white;">
                                <div class="add-task-section-wrapper">
                                    <div class="section-left">
                                        <div class="_btn _btn-default" @click="asanaNewTask(asan.gid)" style="font-size:20px">
                                            <svg class="MiniIcon-custom newTaskButton" viewBox="0 0 24 24" style="width: 20px;height: 20px">
                                                <path d="M10,10V4c0-1.1,0.9-2,2-2s2,0.9,2,2v6h6c1.1,0,2,0.9,2,2s-0.9,2-2,2h-6v6c0,1.1-0.9,2-2,2s-2-0.9-2-2v-6H4c-1.1,0-2-0.9-2-2s0.9-2,2-2H10z"></path>
                                            </svg>
                                            Add New Task 
                                        </div>
                                    </div>
                                    <div class="section-right _text-right">
                                        <div class="_btn _btn-borderless _position-relative nv-dropdown">
                                            <select class="_custom-select"  @change="asanaFilterTask(asan.gid, 'complited', $event)">
                                                <option value="null">All</option>
                                                <option value="true">Complited</option>
                                                <option value="false">Uncomplete</option>
                                            </select>
                                        </div>
                                        <div class="_assigned-box">
                                            <select class="_custom-select" @change="asanaFilterTask(asan.gid, 'assignee', $event)">
                                                <option value="null">All Users</option>
                                                <option v-for="usr in asanaUsers" :key="usr.gid" :value="usr.gid">{{ usr.name }}</option>
                                            </select>
                                        </div>
                                        <!-- <div class="_assigned-box">
                                            <select class="_custom-select" name="">
                                                <option value="">Choose type</option>
                                            </select>
                                        </div> -->
                                        <div class="_assigned-box">
                                            <select class="_custom-select" @change="asanaFilterTask(asan.gid, 'due', $event)">
                                                <option value="null">Choose Due Date</option>
                                                <option value="7">Due in 7 days</option>
                                                <option value="30">Up in 30 days</option>
                                                <option value="90">Up in 90 days</option>
                                            </select>
                                        </div>
                                        <div class="_assigned-box">
                                            <input type="text" class="_custom-input-search" placeholder="Search" @keyup="srchAsanaTask(asan.gid, $event)">
                                            <div class="search-logo">
                                                <svg class="" focusable="false" viewBox="0 0 32 32" style="width: 14px;">
                                                    <path d="M29.707,28.293l-8.256-8.256C23.042,18.13,24,15.677,24,13c0-6.075-4.925-11-11-11S2,6.925,2,13s4.925,11,11,11c2.677,0,5.13-0.958,7.037-2.549l8.256,8.256L29.707,28.293z M4,13c0-4.963,4.037-9,9-9c4.963,0,9,4.037,9,9s-4.037,9-9,9C8.037,22,4,17.963,4,13z"></path>
                                                </svg>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="task-list-wrapper" :class="{'task-list-half': sideBar == 1 ? true:false}" style="background-color: white;padding: unset;">
                                    <div class="task-list-header">
                                        <div class="task-name-box">
                                            Task name
                                        </div>
                                        <div class="task-assignee-box">
                                            Assignee
                                        </div>
                                        <div class="task-assignee-box border-right-none">
                                            Due Date
                                            <div class="logo-1 nv-dropdown">
                                                <svg class="svg-logo" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M25.9,12.9c-0.5-0.6-1.5-0.7-2.1-0.2L16,19.1l-7.8-6.4c-0.6-0.5-1.6-0.4-2.1,0.2c-0.5,0.6-0.4,1.6,0.2,2.1l8.8,7.2  c0.2,0.2,0.6,0.3,0.9,0.3s0.7-0.1,0.9-0.3l8.8-7.2C26.3,14.5,26.4,13.5,25.9,12.9z"></path>
                                                </svg>
                                                <div class="task-head-box-dropdown nv-dropdown-menu">
                                                    <div class="each-box">
                                                        <a href="#">All Task</a>
                                                    </div>
                                                    <div class="each-box">
                                                        <a href="#">All Task</a>
                                                    </div>
                                                    <div class="each-box">
                                                        <a href="#">All Task</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="logo-2">
                                                <svg class="mini-icon" viewBox="0 0 24 24">
                                                    <path d="M4.7,14.1l7.6,7.6c0.4,0.4,1,0.4,1.4,0l7.6-7.6c0.4-0.4,0.4-1,0-1.4s-1-0.4-1.4,0L14,18.6V3c0-0.6-0.4-1-1-1c-0.6,0-1,0.4-1,1v15.6l-5.9-5.9c-0.2-0.2-0.5-0.3-0.7-0.3s-0.5,0.1-0.7,0.3C4.3,13.1,4.3,13.8,4.7,14.1z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div :class="`task-list-body asanaNewTaskCreate-${asan.gid}`" style="display:none">
                                        <div class="task-name-box cursor-pointer" style="padding: 10px;border: 1px solid">
                                            <div class="border-radious-icon" style="visibility: hidden;">
                                                
                                            </div>
                                            <span style="width: 90%;"><input type="text" v-model="asanaTaskCreate.name" :class="`task-body-custom-input asanaInputDesign asanaTaskOnSubmit${asan.gid}`" :id="`asanaNewTaskCreateInput-${asan.gid}`" v-on:keyup.enter="asanaStoreTask(asan)" placeholder="Write a Task Name"></span>
                                            <div  @click="asanaStoreTask(asan)" class="detail-option">Create
                                                <svg class="MiniIcon-right" viewBox="0 0 24 24">
                                                    <path d="M8.9,20.4c-0.4,0-0.7-0.1-1-0.4c-0.6-0.6-0.7-1.5-0.1-2.1l5.2-5.8L7.8,6C7.3,5.4,7.3,4.4,8,3.9C8.6,3.3,9.5,3.4,10.1,4l6.1,7.1c0.5,0.6,0.5,1.4,0,2l-6.1,6.8C9.8,20.3,9.4,20.4,8.9,20.4z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="task-assignee-box cursor-pointer nv-dropdown">
                                            
                                        </div>
                                        <div class="task-date-box cursor-pointer border-right-none">
                                            
                                        </div>
                                    </div>

                                    <div class="collapse-parent collapse-open taskSections" v-for="section in asan.sections" :key="section.gid">
                                        <div class="section-header tabTaskSecTitle" @click="taskTabToggle(`task-${section.gid}`)" style="padding: 15px 5px;">
                                            <div class="d-flex-inline cursor-pointer nv-collapse">{{ section.name }}
                                                <svg style="enable-background:new 0 0 511.626 511.626;width: 23px;height: 23px;"
                                                    class="MiniIcon-right"
                                                    focusable="false" viewBox="0 0 32 32">
                                                    <path d="M25.9,12.9c-0.5-0.6-1.5-0.7-2.1-0.2L16,19.1l-7.8-6.4c-0.6-0.5-1.6-0.4-2.1,0.2c-0.5,0.6-0.4,1.6,0.2,2.1l8.8,7.2  c0.2,0.2,0.6,0.3,0.9,0.3s0.7-0.1,0.9-0.3l8.8-7.2C26.3,14.5,26.4,13.5,25.9,12.9z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div :class="`nv-collapsedown taskSectionHolder-${asan.gid}`" :id="`task-${section.gid}`">
                                            <div class="task-list-body taskSectionsTasks" 
                                                v-for="tasks in section.tasks" 
                                                :key="tasks.details.gid" 
                                                :data-assignee="tasks.assignee.gid" 
                                                :data-complited="tasks.completed ? 'true' : 'false'"
                                                :data-due="tasks.duedate"
                                                :data-name="tasks.details.name"
                                            >
                                                <div class="task-name-box cursor-pointer" style="padding: 0px 0px;">
                                                    <div class="backgroundLoading" :id="`nameB-${tasks.details.gid}`" style="display:none"></div>
                                                    <div class="mainContent task-name-box cursor-pointer"  :id="`nameC-${tasks.details.gid}`" style="padding: 5px 15px;width: 100%;border-right: 0px solid">
                                                        <div @click="tasks.completed = !tasks.completed; asanaEditTask(tasks, 'completed', $event)"
                                                            class="border-radious-icon" :class="{'task-complete': tasks.completed}">
                                                            <svg class="MiniIcon"
                                                                viewBox="0 0 24 24">
                                                                <path d="M9.5,18.2c-0.4,0.4-1,0.4-1.4,0l-3.8-3.8C4,14,4,13.4,4.3,13s1-0.4,1.4,0l3.1,3.1l8.6-8.6c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 L9.5,18.2z"></path>
                                                            </svg>
                                                        </div>
                                                        <span><input type="text" class="task-body-custom-input asanaInputDesign"  @change="asanaEditTask(tasks, 'name', $event)" :value="tasks.details.name"></span>
                                                        <!-- <span class="comment-section-name">
                                                            <span class="comment-count-like">12</span>
                                                            <svg class="comment-logo-like cursor-pointer" viewBox="0 0 24 24"><path
                                                                    d="M2.7,8H5v2v10v2H2.7C1.2,22,0,20.8,0,19.4v-8.7C0,9.2,1.2,8,2.7,8z M23.1,9.2C22.4,8.4,21.5,8,20.5,8H16V5.2 C16,3.5,16.5,2,15.2,1c-0.6-0.5-1.5-0.6-2.2-0.5c-0.8,0.2-1.4,0.7-1.8,1.5L7,8v14h12.2c1.7,0,3.2-1.2,3.4-2.9l1.2-7 C24.1,11,23.8,10,23.1,9.2z"></path></svg>
                                                        </span> -->
                                                        <span class="comment-section-name">
                                                            <span class="comment-count">{{tasks.comments}}</span>
                                                            <svg class=" comment-logo cursor-pointer" focusable="false"
                                                                viewBox="0 0 32 32" height="14px" width="14px">
                                                                <path d="M5,31c-0.1,0-0.3,0-0.4-0.1C4.2,30.7,4,30.4,4,30v-7.1c-2.5-2.3-4-5.5-4-8.9C0,7.4,5.4,2,12,2h8c6.6,0,12,5.4,12,12 s-5.4,12-12,12h-8c-0.1,0-0.3,0-0.4,0l-5.9,4.8C5.4,30.9,5.2,31,5,31z M12,4C6.5,4,2,8.5,2,14c0,3,1.3,5.8,3.6,7.7C5.9,21.9,6,22.2,6,22.5v5.4l4.6-3.7C10.8,24,11,24,11.3,24h0.1c0.2,0,0.4,0,0.6,0h8c5.5,0,10-4.5,10-10S25.5,4,20,4 C20,4,12,4,12,4z"></path>
                                                            </svg>
                                                        </span>
                                                        <span class="comment-section-name"><span class="comment-count">{{tasks.subTasks}}</span>
                                                            <svg class="comment-logo cursor-pointer" focusable="false" viewBox="0 0 32 32" height="14px"
                                                                width="14px">
                                                                <path d="M25,20c-2.4,0-4.4,1.7-4.9,4H11c-3.9,0-7-3.1-7-7v-5h16.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5s-2.2-5-5-5c-2.4,0-4.4,1.7-4.9,4H4V3c0-0.6-0.4-1-1-1S2,2.4,2,3v14c0,5,4,9,9,9h9.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5S27.8,20,25,20z M25,8c1.7,0,3,1.3,3,3s-1.3,3-3,3s-3-1.3-3-3S23.3,8,25,8z M25,28c-1.7,0-3-1.3-3-3s1.3-3,3-3s3,1.3,3,3S26.7,28,25,28z"></path>
                                                            </svg>
                                                        </span>
                                                        <div v-if="sideBar == 0" @click="showTask(tasks.details.gid)" class="detail-option">Detail
                                                            <svg class="MiniIcon-right" viewBox="0 0 24 24">
                                                                <path d="M8.9,20.4c-0.4,0-0.7-0.1-1-0.4c-0.6-0.6-0.7-1.5-0.1-2.1l5.2-5.8L7.8,6C7.3,5.4,7.3,4.4,8,3.9C8.6,3.3,9.5,3.4,10.1,4l6.1,7.1c0.5,0.6,0.5,1.4,0,2l-6.1,6.8C9.8,20.3,9.4,20.4,8.9,20.4z"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="task-assignee-box cursor-pointer nv-dropdown taskNameBoxAnim">
                                                    <div class="backgroundLoading" :id="`assigneeB-${tasks.details.gid}`" style="display:none"></div>
                                                    <div class="nv-dropdown-trigger" :id="`assigneeC-${tasks.details.gid}`">
                                                        <div class="assignee-box-logo">
                                                            <svg class="inside-logo" focusable="false" viewBox="0 0 32 32">
                                                                <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                            </svg>
                                                        </div>
                                                        <span><input type="text" class="assignee-box-input assigned-input"></span>

                                                        <div class="assigned-person" style="padding: 1px !important;">
                                                            <div class="img-box"
                                                                style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png');width: 35px;"></div>
                                                            <div class="text-1">
                                                                <select class="_custom-select asanaAssigneeSelect" v-model="tasks.assignee.gid" @change="asanaEditTask(tasks, 'assignee', $event)">
                                                                    <option value="null">Assign User</option>
                                                                    <option v-for="usr in asanaUsers" :key="usr.gid" :value="usr.gid">{{ usr.name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="task-assignee-box cursor-pointer border-right-none taskNameBoxAnim" :id="`dueOn-${tasks.details.gid}`">
                                                    <div class="backgroundLoading" :id="`dueOnB-${tasks.details.gid}`" style="display:none"></div>
                                                    <span>
                                                        <flat-pickr
                                                            v-model="tasks.duedate"
                                                            :config="{altInput: true, altFormat: 'F j, Y'}"
                                                            @on-change="asanaEditTask(tasks, 'dueOn', $event)"
                                                            class="assignee-box-input assigned-input form-control input active"
                                                            :id="`dueOnC-${tasks.details.gid}`"
                                                            name="date">
                                                        </flat-pickr>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="task-list-detail-wrapper" id="task-detail" :class="{'hideMe': sideBar == 0 ? true:false}">
                                <div class="loader-io backgroundLoading" style="display: none">
                                    <div class="loadingio-spinner-eclipse-utvtio44ngo">
                                        <div class="ldio-aebf04cd3u backgroundLoading">
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="task-details-wrapper" v-if="taskDetails">
                                    <div class="add-task-section-wrapper">
                                        <div class="section-left">
                                            <div :class="{'_btn': true, '_btn-default':true, '_btn _btn-default-active': taskDetails[0].data.completed ? true : false}">
                                                <svg class="MiniIcon-custom" viewBox="0 0 24 24">
                                                    <path d="M9.2,20c-0.5,0.5-1.3,0.5-1.9,0l-5.1-5.1c-0.4-0.5-0.4-1.3,0-1.9c0.4-0.5,1.3-0.5,1.9,0l4.1,4.1L19.7,5.7 c0.5-0.5,1.3-0.5,1.9,0s0.5,1.3,0,1.9L9.2,20z"></path>
                                                </svg>
                                                <span v-if="taskDetails[0].data.completed" onclick="document.getElementById('taskDetailsCompleteness').click()">Completed</span>
                                                <span v-else="" onclick="document.getElementById('taskDetailsCompleteness').click()">Mark As Complete</span>
                                                <input type="checkbox" v-if="taskDetails[0].data.completed" @click="inlineTaskUpdate(taskDetails[0].data.memberships[0].section.gid, taskDetails[0].data.gid, 'completed', $event)" id="taskDetailsCompleteness" style="display:none;" checked>
                                                <input type="checkbox" v-else="" @click="inlineTaskUpdate(taskDetails[0].data.memberships[0].section.gid, taskDetails[0].data.gid, 'completed', $event)" id="taskDetailsCompleteness" style="display:none;">
                                            </div>
                                        </div>
                                        <div class="section-right _text-right">
                                            <input type="file" id="file" name="file" v-on:change="handleFileUpload(taskDetails[0].data.gid, $event)" style="display: none">
                                            <div class="logo-box" onclick="document.getElementById('file').click()">
                                                <svg class="hide-box-icon" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M19,32c-3.9,0-7-3.1-7-7V10c0-2.2,1.8-4,4-4s4,1.8,4,4v9c0,0.6-0.4,1-1,1s-1-0.4-1-1v-9c0-1.1-0.9-2-2-2s-2,0.9-2,2v15c0,2.8,2.2,5,5,5s5-2.2,5-5V10c0-4.4-3.6-8-8-8s-8,3.6-8,8v5c0,0.6-0.4,1-1,1s-1-0.4-1-1v-5C6,4.5,10.5,0,16,0s10,4.5,10,10v15C26,28.9,22.9,32,19,32z"></path>
                                                </svg>
                                            </div>
                                            <div class="logo-box" @click="createNewSubTask = true">
                                                <svg class="hide-box-icon" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M25,20c-2.4,0-4.4,1.7-4.9,4H11c-3.9,0-7-3.1-7-7v-5h16.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5s-2.2-5-5-5c-2.4,0-4.4,1.7-4.9,4H4V3c0-0.6-0.4-1-1-1S2,2.4,2,3v14c0,5,4,9,9,9h9.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5S27.8,20,25,20z M25,8c1.7,0,3,1.3,3,3s-1.3,3-3,3s-3-1.3-3-3S23.3,8,25,8z M25,28c-1.7,0-3-1.3-3-3s1.3-3,3-3s3,1.3,3,3S26.7,28,25,28z"></path>
                                                </svg>
                                            </div>
                                            <div class="logo-box">
                                                <a title="Delete" @click="deleteTask(taskDetails[0].data)"
                                                class="appearance-none cursor-pointer text-70 hover:text-danger mr-3">
                                                    <svg class="hide-box-icon" viewBox="0 0 20 20" aria-labelledby="delete" role="presentation">
                                                        <path fill-rule="nonzero" d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="logo-box">
                                                <span class="like-count" v-if="taskDetails[0].data.num_likes">{{ taskDetails[0].data.num_likes }}</span>
                                                <svg class="hide-box-icon-primary" focusable="false" viewBox="0 0 32 32" v-if="taskDetails[0].data.num_likes">
                                                    <path d="M5,15c-1.1,0-2,0.9-2,2v10c0,1.1,0.9,2,2,2h1.9c0.6,0,1-0.4,1-1V16c0-0.6-0.4-1-1-1H5z M26.5,13H19V7.5c0-1.6-0.7-3-2-4l0,0c-1-0.8-2.5-0.4-3,0.7l-3.3,9c-0.4,1-0.5,2-0.5,3V28c0,0.6,0.4,1,1,1h13.9c1.5,0,2.7-1.1,3-2.5l1.6-10C29.7,14.6,28.3,13,26.5,13z"></path>
                                                </svg>
                                                <svg class="hide-box-icon " focusable="false" viewBox="0 0 32 32" v-else="">
                                                    <path d="M29.6,13.3c-0.8-0.9-1.9-1.4-3.1-1.4h-6.4V7.5c0-1.9-0.9-3.8-2.5-4.9C16.9,2,15.9,1.8,15,2.1c-0.9,0.2-1.7,0.8-2,1.7L8.3,13.9H5c-1.7,0-3.1,1.4-3.1,3.1v10c0,1.7,1.4,3.1,3.1,3.1h2.9H9h15.9c2,0,3.7-1.5,4-3.5l1.6-10C30.7,15.4,30.4,14.2,29.6,13.3z M5,27.9c-0.5,0-0.9-0.4-0.9-0.9V17c0-0.5,0.4-0.9,0.9-0.9h2.9v11.8C7.9,27.9,5,27.9,5,27.9z M28.4,16.3l-1.6,10c-0.1,0.9-0.9,1.6-1.9,1.6H10.1V15.2L15,4.7c0.2-0.3,0.4-0.5,0.6-0.5c0.2,0,0.5-0.1,0.8,0.2c1,0.7,1.6,1.9,1.6,3.2v6.6h8.6c0.6,0,1.1,0.2,1.5,0.7C28.3,15.2,28.5,15.7,28.4,16.3z"></path>
                                                </svg>
                                            </div>
                                            <div class="logo-box" @click="sideBar == 1 ? sideBar = 0 : sideBar = 1">
                                                <svg class="hide-box-icon" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M2,14.5h18.4l-7.4-7.4c-0.6-0.6-0.6-1.5,0-2.1c0.6-0.6,1.5-0.6,2.1,0l10,10c0.6,0.6,0.6,1.5,0,2.1l-10,10c-0.3,0.3-0.7,0.4-1.1,0.4c-0.4,0-0.8-0.1-1.1-0.4c-0.6-0.6-0.6-1.5,0-2.1l7.4-7.4H2c-0.8,0-1.5-0.7-1.5-1.5C0.5,15.3,1.2,14.5,2,14.5z M28,3.5C28,2.7,28.7,2,29.5,2S31,2.7,31,3.5v25c0,0.8-0.7,1.5-1.5,1.5S28,29.3,28,28.5V3.5z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="head-text-section">
                                        <div v-if="taskParents.length > 0" v-for="(parent, index) in taskParents" :key="index" title="Parent's notes and comments" @click="showParentTask(parent.id, index)">
                                            <a href="javascript:void(0)" class="parent-task">{{ parent.name }}<svg viewBox="0 0 24 24" class="MiniIcon-right"><path d="M8.9,20.4c-0.4,0-0.7-0.1-1-0.4c-0.6-0.6-0.7-1.5-0.1-2.1l5.2-5.8L7.8,6C7.3,5.4,7.3,4.4,8,3.9C8.6,3.3,9.5,3.4,10.1,4l6.1,7.1c0.5,0.6,0.5,1.4,0,2l-6.1,6.8C9.8,20.3,9.4,20.4,8.9,20.4z"></path></svg></a>
                                        </div>
                                    </div>
                                    <div class="head-text-section padding-head-text-10">
                                        <input type="text" class="input-big" placeholder="Write a task name" :value="taskDetails[0].data.name" @change="inlineTaskUpdate(taskDetails[0].data.memberships[0].section.gid, taskDetails[0].data.gid, 'name', $event)">
                                    </div>
                                    <div class="head-text-section border-bottom-task-list">
                                        <div class="radious-square-input cursor-pointer nv-dropdown">
                                            <div class="logo-border">
                                                <svg class="input-icon-1" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                </svg>
                                            </div>

                                            <input type="text" placeholder="Assignee" class="input-design" @keyup="textSearch($event, false)" @click="openUserDiv" @blur="clearInput($event, false)">

                                            <div class="assigned-person" v-if="taskDetails[0].data.assignee">
                                                <div class="img-box" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                <div class="text-1">{{ taskDetails[0].data.assignee.name }}</div>
                                            </div>

                                            <div class="assignee-box-dropdown nv-dropdown-menu" id="openUserDiv">
                                                <div class="each-assignee" v-if="users.length > 0" v-for="user in asanaUsers" @click="inlineTaskUpdate(taskDetails[0].data.memberships[0].section.gid, taskDetails[0].data.gid, 'assignee', user)">
                                                    <div class="profile-img"
                                                        style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                    <div class="name-text">{{ user.name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="radious-square-input">
                                            <div class="logo-border">
                                                <svg class="input-icon-2" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                </svg>
                                            </div>
                                            <flat-pickr
                                                :value="taskDetails[0].data.due_on"
                                                :config="{altInput: true, altFormat: 'F j, Y'}"
                                                @on-change="inlineTaskUpdate(taskDetails[0].data.memberships[0].section.gid, taskDetails[0].data.gid, 'due_on', $event)"
                                                class="input-design"
                                                :class="{'width-big': taskDetails[0].data.due_on ? true : false}"
                                                placeholder="Due date"
                                                name="due_on">
                                            </flat-pickr>
                                        </div>
                                    </div>
                                    <div class="head-text-section">
                                        <div class="text-area-logo">
                                            <svg class="t-logo" focusable="false" viewBox="0 0 32 32">
                                                <path d="M31,8H1C0.4,8,0,7.6,0,7s0.4-1,1-1h30c0.6,0,1,0.4,1,1S31.6,8,31,8z M23,14H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,14,23,14z M27,20H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h26c0.6,0,1,0.4,1,1S27.6,20,27,20z M19,26H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h18c0.6,0,1,0.4,1,1S19.6,26,19,26z"></path>
                                            </svg>
                                        </div>
                                        <textarea name="" class="custom-text-area" cols="30" rows="5" placeholder="Description" :value="taskDetails[0].data.notes" @change="inlineTaskUpdate(taskDetails[0].data.memberships[0].section.gid, taskDetails[0].data.gid, 'notes', $event)"></textarea>
                                    </div>
                                    <div class="head-text-section _position-relative border-bottom-task-list">
                                        <div class="_input-logo">
                                            <svg class="t-logo" focusable="false" viewBox="0 0 32 32">
                                                <path d="M10,13.5c0.8,0,1.5,0.7,1.5,1.5s-0.7,1.5-1.5,1.5S8.5,15.8,8.5,15S9.2,13.5,10,13.5z M23,14h-8c-0.6,0-1,0.4-1,1s0.4,1,1,1h8c0.6,0,1-0.4,1-1S23.6,14,23,14z M23,20h-8c-0.6,0-1,0.4-1,1s0.4,1,1,1h8c0.6,0,1-0.4,1-1S23.6,20,23,20z M10,19.5c0.8,0,1.5,0.7,1.5,1.5s-0.7,1.5-1.5,1.5S8.5,21.8,8.5,21S9.2,19.5,10,19.5z M24,2h-2.2c-0.4-1.2-1.5-2-2.8-2h-6c-1.3,0-2.4,0.8-2.8,2H8C4.7,2,2,4.7,2,8v18c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M13,2h6c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1h-6c-0.6,0-1-0.4-1-1V3C12,2.4,12.4,2,13,2z M28,26c0,2.2-1.8,4-4,4H8c-2.2,0-4-1.8-4-4V8c0-2.2,1.8-4,4-4h2v1c0,1.7,1.3,3,3,3h6c1.7,0,3-1.3,3-3V4h2c2.2,0,4,1.8,4,4V26z"></path>
                                            </svg>
                                        </div>
                                        <div class="project-name-label">{{ taskDetails[0].data.projects[0] ? taskDetails[0].data.projects[0].name : null }}</div>
                                        <div class="project-select-box">
                                            <select @change="inlineTaskUpdate(taskDetails[0].data.memberships[0].section.gid, taskDetails[0].data.gid, 'section', $event)" class="cursor-pointer">
                                                <option v-for="projSectn in detSections" :key="projSectn.gid" :value="projSectn.gid" v-if="projSectn.selected == true" selected>{{ projSectn.name }}</option>
                                                <option :value="projSectn.gid" v-else="">{{ projSectn.name }}</option>
                                            </select>
                                        </div>
                                        <div class="new-task" v-if="createNewSubTask">
                                            <div class="border-radious-icon">
                                                <svg class="MiniIcon"
                                                    viewBox="0 0 24 24">
                                                    <path d="M9.5,18.2c-0.4,0.4-1,0.4-1.4,0l-3.8-3.8C4,14,4,13.4,4.3,13s1-0.4,1.4,0l3.1,3.1l8.6-8.6c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 L9.5,18.2z"></path>
                                                </svg>
                                            </div>
                                            <input type="text" class="new-task-input" v-model="subTask.name">
                                            <div class="new-task-logo">
                                                <div class="logo-1" @click="createSubTask(taskDetails[0].data)">
                                                    <div class="detail-option">Create
                                                        <svg viewBox="0 0 24 24" class="MiniIcon-right"><path d="M8.9,20.4c-0.4,0-0.7-0.1-1-0.4c-0.6-0.6-0.7-1.5-0.1-2.1l5.2-5.8L7.8,6C7.3,5.4,7.3,4.4,8,3.9C8.6,3.3,9.5,3.4,10.1,4l6.1,7.1c0.5,0.6,0.5,1.4,0,2l-6.1,6.8C9.8,20.3,9.4,20.4,8.9,20.4z"></path></svg>
                                                    </div>
                                                </div>
                                                <div class="logo-1 nv-dropdown">
                                                    <div class="new-task-date cursor-pointer" v-if="subTask.due_on">{{ new Date(subTask.due_on).toDateString() }}</div>
                                                    <div class="icon-border cursor-pointer" v-else="">
                                                        <svg class="_icon" focusable="false" viewBox="0 0 32 32">
                                                            <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="assignee-box-dropdown nv-dropdown-menu">
                                                        <flat-pickr
                                                            @on-change="subTask.due_on = convert($event)"
                                                            :config="{inline: true, altInput: true, altFormat: 'F j, Y'}"
                                                            class="date-input-uder-new-task">
                                                        </flat-pickr>
                                                    </div>
                                                </div>
                                                <div class="logo-1 cursor-pointer nv-dropdown">
                                                    <div class="new-task-date cursor-pointer" v-if="subTask.assignee">{{ users[users.findIndex((element) => element.gid == subTask.assignee)].name }}</div>
                                                    <div class="icon-border" v-else="">
                                                        <svg class="_icon cursor-pointer" focusable="false" viewBox="0 0 32 32">
                                                            <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="assignee-box-dropdown no-overflow nv-dropdown-menu">
                                                        <div class="_position-relative nv-dropdown-under-input">
                                                            <label class="ass-label">Assignee</label>
                                                            <br>
                                                            <input type="text" placeholder="Name" class="drop-down-input" @keyup="textSearch($event, true)" @blur="clearInput($event, true)">
                                                            <div class="assignee-box-dropdown-under-input nv-dropdown-menu-under-input">
                                                                <div class="each-assignee-under-input" v-if="users.length > 0" v-for="user in users" @click="subTask.assignee = user.gid">
                                                                    <div class="profile-img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                                    <div class="name-text">{{ user.name }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="new-task" v-if="taskDetails.subTasks.length > 0" v-for="(t, index) in taskDetails.subTasks" :key="index" style="height: 40px;">
                                            <div class="border-radious-icon" :class="{'task-complete': t[0].data.completed ? true : false}" onclick="document.getElementById('subTaskCompleteness').click()">
                                                <svg class="MiniIcon"
                                                    viewBox="0 0 24 24">
                                                    <path d="M9.5,18.2c-0.4,0.4-1,0.4-1.4,0l-3.8-3.8C4,14,4,13.4,4.3,13s1-0.4,1.4,0l3.1,3.1l8.6-8.6c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 L9.5,18.2z"></path>
                                                </svg>
                                            </div>
                                            <input type="checkbox" style="display: none" v-if="t[0].data.completed" id="subTaskCompleteness" checked @click="inlineSubTaskUpdate(t[0].data.gid, index, 'completed', $event)">
                                            <input type="checkbox" style="display: none" v-else="" id="subTaskCompleteness" @click="inlineSubTaskUpdate(t[0].data.gid, index, 'completed', $event)">
                                            <input type="text" class="new-task-input" :value="t[0].data.name" @change="inlineSubTaskUpdate(t[0].data.gid, index, 'name', $event)">
                                            <div class="new-task-logo">
                                                <div class="logo-1 nv-dropdown">
                                                    <div class="new-task-date cursor-pointer" v-if="t[0].data.due_on" :title="duedate(t[0].data.due_on)">{{ new Date(t[0].data.due_on).toDateString() }}</div>
                                                    <div class="icon-border cursor-pointer" v-else="">
                                                        <svg class="_icon" focusable="false" viewBox="0 0 32 32">
                                                            <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="assignee-box-dropdown nv-dropdown-menu">
                                                        <flat-pickr
                                                            :value="t[0].data.due_on"
                                                            @on-change="inlineSubTaskUpdate(t[0].data.gid, index, 'due_on', $event)"
                                                            :config="{inline: true, altInput: true, altFormat: 'F j, Y'}"
                                                            class="date-input-uder-new-task">
                                                        </flat-pickr>
                                                    </div>
                                                </div>
                                                <div class="logo-1 cursor-pointer nv-dropdown">
                                                    <div class="new-task-date cursor-pointer" v-if="t[0].data.assignee">{{ t[0].data.assignee.name }}</div>
                                                    <div class="icon-border" v-else="">
                                                        <svg class="_icon cursor-pointer" focusable="false" viewBox="0 0 32 32">
                                                            <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="assignee-box-dropdown no-overflow nv-dropdown-menu">
                                                        <div class="_position-relative nv-dropdown-under-input">
                                                            <label class="ass-label">Assignee</label>
                                                            <br>
                                                            <input type="text" placeholder="Name" class="drop-down-input" @keyup="textSearch($event, true)" @blur="clearInput($event, true)">
                                                            <div class="assignee-box-dropdown-under-input nv-dropdown-menu-under-input">
                                                                <div class="each-assignee-under-input" v-if="users.length > 0" v-for="user in users" @click="inlineSubTaskUpdate(t[0].data.gid, index, 'assignee', user)">
                                                                    <div class="profile-img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                                    <div class="name-text">{{ user.name }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="section-comment" @click="showChildTask(t[0].data.gid, taskDetails[0].data.gid, taskDetails[0].data.name)">
                                                    <span class="comment-count" v-if="t.comments">{{ t.comments.data ? t.comments.data.length : 0 }}</span>
                                                    <div class="logo-2">
                                                        <svg class="_icon cursor-pointer" focusable="false"
                                                            viewBox="0 0 32 32">
                                                            <path d="M5,31c-0.1,0-0.3,0-0.4-0.1C4.2,30.7,4,30.4,4,30v-7.1c-2.5-2.3-4-5.5-4-8.9C0,7.4,5.4,2,12,2h8c6.6,0,12,5.4,12,12 s-5.4,12-12,12h-8c-0.1,0-0.3,0-0.4,0l-5.9,4.8C5.4,30.9,5.2,31,5,31z M12,4C6.5,4,2,8.5,2,14c0,3,1.3,5.8,3.6,7.7C5.9,21.9,6,22.2,6,22.5v5.4l4.6-3.7C10.8,24,11,24,11.3,24h0.1c0.2,0,0.4,0,0.6,0h8c5.5,0,10-4.5,10-10S25.5,4,20,4 C20,4,12,4,12,4z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="logo-2">
                                                        <svg class="_icon cursor-pointer" focusable="false"
                                                            viewBox="0 0 32 32">
                                                            <path d="M23.2,16c0,0.3-0.1,0.7-0.3,0.9l-9,11c-0.5,0.6-1.5,0.7-2.1,0.2s-0.7-1.5-0.2-2.1l8.2-10L11.6,6c-0.5-0.6-0.4-1.6,0.2-2.1s1.6-0.4,2.1,0.2l9,11C23.1,15.3,23.2,15.7,23.2,16z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="head-text-section border-bottom-task-list" v-if="taskDetails.comments.length > 0">
                                        <div class="comment-bar" v-for="comment in taskDetails.comments" v-if="comment[0].type == 'comment'">
                                            <div class="profile-img">
                                                <div class="_img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                            </div>
                                            <div class="detail-text-area">
                                                <span><a class="lnk-text" href="javascript:void(0)">{{ comment[0].created_by.name }} </a></span>
                                                <span class="small-text"><vue-moments-ago prefix="" suffix="ago" :date="comment[0].created_at"></vue-moments-ago></span>
                                                <div class="comment-each">{{ comment[0].text }}</div>
                                            </div>
                                            <div class="like-option cursor-pointer">
                                                <span class="like-count" v-if="comment['details']['data'].num_likes">{{ comment['details']['data'].num_likes }}</span>
                                                <svg viewBox="0 0 24 24" class="like-button-active" v-if="comment['details']['data'].num_likes">
                                                    <path d="M2.7,8H5v2v10v2H2.7C1.2,22,0,20.8,0,19.4v-8.7C0,9.2,1.2,8,2.7,8z M23.1,9.2C22.4,8.4,21.5,8,20.5,8H16V5.2 C16,3.5,16.5,2,15.2,1c-0.6-0.5-1.5-0.6-2.2-0.5c-0.8,0.2-1.4,0.7-1.8,1.5L7,8v14h12.2c1.7,0,3.2-1.2,3.4-2.9l1.2-7 C24.1,11,23.8,10,23.1,9.2z"></path>
                                                </svg>
                                                <svg focusable="false" viewBox="0 0 32 32" class="like-button" v-else>
                                                    <path d="M29.6,13.3c-0.8-0.9-1.9-1.4-3.1-1.4h-6.4V7.5c0-1.9-0.9-3.8-2.5-4.9C16.9,2,15.9,1.8,15,2.1c-0.9,0.2-1.7,0.8-2,1.7L8.3,13.9H5c-1.7,0-3.1,1.4-3.1,3.1v10c0,1.7,1.4,3.1,3.1,3.1h2.9H9h15.9c2,0,3.7-1.5,4-3.5l1.6-10C30.7,15.4,30.4,14.2,29.6,13.3z M5,27.9c-0.5,0-0.9-0.4-0.9-0.9V17c0-0.5,0.4-0.9,0.9-0.9h2.9v11.8C7.9,27.9,5,27.9,5,27.9z M28.4,16.3l-1.6,10c-0.1,0.9-0.9,1.6-1.9,1.6H10.1V15.2L15,4.7c0.2-0.3,0.4-0.5,0.6-0.5c0.2,0,0.5-0.1,0.8,0.2c1,0.7,1.6,1.9,1.6,3.2v6.6h8.6c0.6,0,1.1,0.2,1.5,0.7C28.3,15.2,28.5,15.7,28.4,16.3z"></path>
                                                </svg>
                                                <!--<span class="nv-dropdown">
                                                    <svg focusable="false" viewBox="0 0 32 32" class="" style="width: 20px; height: 18px"><path
                                                        d="M25.9,12.9c-0.5-0.6-1.5-0.7-2.1-0.2L16,19.1l-7.8-6.4c-0.6-0.5-1.6-0.4-2.1,0.2c-0.5,0.6-0.4,1.6,0.2,2.1l8.8,7.2  c0.2,0.2,0.6,0.3,0.9,0.3s0.7-0.1,0.9-0.3l8.8-7.2C26.3,14.5,26.4,13.5,25.9,12.9z"></path></svg>
                                                    <div class="task-head-box-dropdown nv-dropdown-menu">
                                                        <div class="each-box"><a href="javascript:void(0)">Edit Task</a></div>
                                                        <div class="each-box"><a href="javascript:void(0)">Delete Task</a></div>
                                                    </div>
                                                </span>-->
                                            </div>
                                        </div>
                                        <div class="history-bar" v-else>
                                            <div class="profile-img">
                                                <div class="_img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                            </div>
                                            <div class="detail-text-area">
                                                <span><a class="lnk-text" href="javascript:void(0)">{{ comment[0].created_by.name }} </a>{{ comment[0].text }}</span>
                                                <span class="small-text"><vue-moments-ago prefix="" suffix="ago" :date="comment[0].created_at"></vue-moments-ago></span>
                                            </div>
                                            <div class="detail-text-area">
                                                <span class="small-text">{{ comment[0].created_by.name }} {{ comment[0].text }} <vue-moments-ago prefix="" suffix="ago" :date="comment[0].created_at"></vue-moments-ago></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="head-text-section bg-light">
                                        <div class="profile-img">
                                            <div class="_img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                        </div>
                                        <textarea @change="storeTaskComment(taskDetails[0].data.gid)" v-model="taskComment" class="custom-text-area-chat" cols="30" rows="5" placeholder="Ask a question or post an update"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabContent" id="actionTabContent" style="max-width: 1000px;margin: 0px auto;">
                        <div class="wrap-detailBox">
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('com')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square" style="padding-right: 10px;"></i>Community Status</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="comInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('tym')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>Change Requests</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="tymInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                            <div>
                                <div class="label-square hoverUnderLine" @click="communityOpen('flm')" style="position: relative;">
                                    <div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" style="position: absolute;top: 0px;right: 0px;"></div>
                                    <h4><i class="fa-xs fas fa-square"></i>Activity Log</h4>
                                </div>
                                <div class="openInfo cmOpenInfo" id="flmInfo" style="display:none">
                                    <span>Some Content</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2';
    import $ from '../../static/js/jquery-2.2.4.min';
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import {VTooltip, VPopover, VClosePopover} from 'v-tooltip'
    import VueMomentsAgo from 'vue-moments-ago'

    export default {
        directives: {
            tooltip: VTooltip,
            'v-popover': VClosePopover,
        },
        components: {
            'v-popover': VPopover,
            flatPickr,
            VueMomentsAgo
        },
        props: [
            'card',
            'resource',
            'resourceId',
            'resourceName',
        ],
        watch: {
            resourceId: function (val) {
                this.loaded = false;
                this.getPendingChangeCount();
                Nova.request().post('/nova-vendor/community-summary/community', {
                    communityId: this.resourceId
                }).then(response => {
                    console.log(response.data);
                    this.community = response.data[0];
                    this.loaded = true;
                });
                Nova.request().post('/nova-vendor/community-summary/foreclosures', {
                    communityId: this.resourceId
                }).then(response => {
                    this.estForeclosures = response.data;
                })
            }
        },
        data: function () {
            return {
                community: null,
                estForeclosures: 0,
                loaded: false,
                latestActivity: null,
                pendingChanges: 0,
                projects: [],
                activeProject: null,
                tasks: [],
                users: [],
                sections: [],
                sectionData: [],
                errors: [],
                success: null,
                projectDetails: null,
                isLoading: true,
                project: {
                    id: null,
                    name: null,
                    workspace: '25961259746709',
                    team: '1147285102599070',
                    osusr_mlv_community_id: this.resourceId,
                },
                task: {
                    name: '',
                    workspace: '',
                    assignee: '',
                    due_on: '',
                    notes: '',
                    section: '',
                    projects: [],
                },
                taskUpdate: {
                    id: null,
                    name: '',
                    workspace: '',
                    assignee: '',
                    due_on: '',
                    notes: '',
                    completed: '',
                    section: '',
                },
                subTask: {
                    name: '',
                    assignee: '',
                    due_on: '',
                    project: '',
                },
                subTaskUpdate: {
                    name: '',
                    assignee: '',
                    due_on: '',
                    project: '',
                },
                taskFilter: {
                    name: '',
                    assignee: '',
                    due_on: '',
                    notes: '',
                    section: '',
                    project: '',
                    complete: '',
                },
                keywordTyping: null,
                config: {
                    altFormat: 'M j, Y',
                    altInput: true,
                    dateFormat: 'Y-m-d',
                },
                taskDetails: null,
                file: '',
                taskComment: '',
                createNewSubTask: false,
                createNewTask: false,
                taskParents: [],
                sideBar: 0,
                asanaLoading:true,
                asana:[],
                asanaTaskCreate:{
                    name: '',
                    workspace: '',
                    assignee: '',
                    due_on: '',
                    notes: '',
                    section: '',
                    projects: [],
                },
                asanaUsers:[],
                detSections: {}
            }
        },
        computed: {
            communityName() {
                if (this.community) {
                    console.log('this.community',this.community)
                    return this.community.misc_configuration ? (this.community.misc_configuration.custom_friendly_name ? this.community.misc_configuration.custom_friendly_name : this.community.FRIENDLYNAME) : this.community.FRIENDLYNAME;
                } else {
                    return "";
                }
            },
            lastUpdatedSubject() {
                if (this.latestActivity) {
                    switch (this.latestActivity.subject_type) {
                        case "App\\Models\\CommunitySalesConfiguration":
                            return " the Sales Configuration";
                        case "App\\Models\\Contact":
                            return " a Person";
                        case "App\\Models\\Contract":
                            return " a Contract";
                        case "App\\Models\\RelationshipManager":
                            return " a RM";
                        case "App\\Models\\Interaction":
                            return " an Interaction";
                        case "App\\Models\\CommunityConfiguration":
                            return " the Branding Configuration";
                        case "App\\Models\\CommunityMiscConfiguration":
                            return " the Misc Configuration";
                        case "App\\Models\\CMCommunity":
                            return " the Misc Configuration";
                        case "App\\Models\\RentalVacantSalesStatus":
                            return " a Sales Status";
                        case "App\\Models\\CommunityLogo":
                            return " the Community Logo";
                        case "App\\Models\\CRMCommunitySale":
                            return " a Sales Status";
                        case "App\\Models\\SalesActivity":
                            return " a Sales Activity";
                        case "App\\Models\\SalesCycle":
                            return " a Sales Cycle";
                        default:
                            return this.latestActivity.subject_type
                    }
                }
            },
            lastUpdated() {
                if (this.latestActivity) {
                    return this.latestActivity.user ? this.latestActivity.user.name + " " + this.latestActivity.description + this.lastUpdatedSubject + " " + moment(this.latestActivity.updated_at).fromNow() : ""
                } else {
                    return 'No Updates to report'
                }
            },
            pendingChangeText() {
                return this.pendingChanges + "</span> Pending Change" + (this.pendingChanges === 1 ? "" : "s")
            },
            activityDiff() {
                function changes(object, base) {
                    return _.transform(object, function (result, value, key) {
                        if (!_.isEqual(value, base[key]) && key !== 'updated_at') {
                            result[key] = (_.isObject(value) && _.isObject(base[key])) ? changes(value, base[key]) : value;
                        }
                    });
                }

                if (this.latestActivity !== "" && this.latestActivity !== null) {
                    return changes(JSON.parse(this.latestActivity.properties).attributes, JSON.parse(this.latestActivity.properties).old);
                } else {
                    return null;
                }
            },
            newCountyFilter() {
                return Buffer.from(JSON.stringify(this.filter), 'binary').toString('base64')
            },
            string() {
                return JSON.stringify(this.filter);
            },
            countyFilter() {
                return Buffer.from("[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityRentalSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":false,\"14\":false}},{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityVacantSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":false,\"14\":false}},{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityForeclosureSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":false,\"14\":false}},{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunitySize\",\"value\":{\"0\":false,\"1\":false,\"2\":false,\"3\":false,\"4\":false}},{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityState\",\"value\":\"" + (this.community ? (this.community.state ? this.community.state.code : '') : '') + "\"},{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityCounty\",\"value\":\"" + (this.community ? this.community.COUNTY : "") + "\"},{\"class\":\"App\\\\Nova\\\\Filters\\\\RelationshipManager\",\"value\":\"\"}]", 'binary').toString('base64')
            },
            countyFilterUrl() {
                return "/admin/resources/c-m-communities?c-m-communities_filter=" + this.countyFilter
            },
            relationshipStatusNotes() {
                if (this.community) {
                    if (this.community.sales_configuration) {
                        return this.community.sales_configuration.relationship_status_notes
                    }
                }
            },
            brandingUrlRedirectStatus() {
                if (this.community) {
                    if (this.community.branding_configuration) {
                        if (this.community.branding_configuration.redirect_url) {
                            return "<div class='table-cell'>Redirect URL: &nbsp;&nbsp;&nbsp;<span style='color: green'>&#10004;</span></div>"
                        } else {
                            return "<div class='table-cell'>Redirect URL: &nbsp;&nbsp;&nbsp;<span style='color: red'>&#10008;</span></div>"
                        }
                    } else {
                        return "<div class='table-cell'>Redirect URL: &nbsp;&nbsp;&nbsp;<span style='color: red'>&#10008;</span></div>"
                    }
                }
            },
            brandingEmailRedirectStatus() {
                if (this.community) {
                    if (this.community.branding_configuration) {
                        if (this.community.branding_configuration.redirect_url) {
                            return "<div class='table-cell'>Redirect Email: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color: green'>&#10004;</span></div>"
                        } else {
                            return "<div class='table-cell'>Redirect Email: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color: red'>&#10008;</span></div>"
                        }
                    } else {
                        return "<div class='table-cell'>Redirect Email: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color: red'>&#10008;</span></div>"
                    }
                }
            },
            brandingPhoneRedirectStatus() {
                if (this.community) {
                    if (this.community.branding_configuration) {
                        if (this.community.branding_configuration.redirect_phone) {
                            return "<div class='table-cell'>Redirect Phone: <span style='color: green'>&#10004;</span></div>"
                        } else {
                            return "<div class='table-cell'>Redirect Phone: <span style='color: red'>&#10008;</span></div>"
                        }
                    } else {
                        return "<div class='table-cell'>Redirect Phone: <span style='color: red'>&#10008;</span></div>"
                    }
                }
            },
            communityPageURLStatus() {
                if (this.community) {
                    if (this.community.branding_configuration) {
                        if (this.rentalPartner) {
                            if (!this.community.branding_configuration.community_page_rental_url) {
                                return "<div class='table-cell'>Community Page URL: <span style='color: red'>&#10008;</span></div>"
                            }
                        }
                        if (this.vacantPartner) {
                            if (!this.community.branding_configuration.community_page_vacant_url) {
                                return "<div class='table-cell'>Community Page URL: <span style='color: red'>&#10008;</span></div>"
                            }
                        }
                        if (this.foreclosurePartner) {
                            if (!this.community.branding_configuration.community_page_foreclosure_url) {
                                return "<div class='table-cell'>Community Page URL: <span style='color: red'>&#10008;</span></div>"
                            }
                        }
                    } else {
                        return "<div class='table-cell'>Community Page URL: <span style='color: red'>&#10008;</span></div>"
                    }
                    return "<div class='table-cell'>Community Page URL: <span style='color: green'>&#10004;</span></div>"
                }
            },
            brandingConfigTooltip() {
                if (this.community) {
                    return "<div class='table-row'>" + this.brandingUrlRedirectStatus + this.brandingEmailRedirectStatus + '</div>' +
                        "<div class='table-row'>" + this.brandingPhoneRedirectStatus + this.communityPageURLStatus + "</div>"
                }
            },
            specialOversightNotes() {
                if (this.community) {
                    if (this.community.sales_configuration) {
                        return this.community.sales_configuration.special_oversight_notes
                    }

                }
            },
            stateLink() {
                if (this.community) {
                    if (this.community.state) {
                        return '/resources/states/' + this.community.state.id + '/edit?viaResourceId=' + this.resourceId
                    }
                } else {
                    return ''
                }
            },
            rentalPartner() {
                return this.community ? (this.community.rental_vacant_sales_status ? this.community.rental_vacant_sales_status.rental_partner_status : false) : false;
            },
            vacantPartner() {
                return this.community ? (this.community.rental_vacant_sales_status ? this.community.rental_vacant_sales_status.vacant_partner_status : false) : false;
            },
            foreclosurePartner() {
                return this.community ? (this.community.rental_vacant_sales_status ? this.community.rental_vacant_sales_status.foreclosure_partner_status : false) : false;
            },
            rentalSalesStatus() {
                if (this.community) {
                    if (this.community.sales_cycles) {
                        let filteredSalesStages = _.filter(this.community.sales_cycles, function (o) {
                            return o.active && o.rental;
                        });
                        if (filteredSalesStages.length > 0) {
                            return this.salesStatus(parseInt(filteredSalesStages[0].sales_stage))
                        } else {
                            return 0;
                        }
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            },
            vacantSalesStatus() {
                if (this.community) {
                    if (this.community.sales_cycles) {
                        let filteredSalesStages = _.filter(this.community.sales_cycles, function (o) {
                            return o.active && o.vacant;
                        });
                        if (filteredSalesStages.length > 0) {
                            return this.salesStatus(parseInt(filteredSalesStages[0].sales_stage))
                        } else {
                            return 0;
                        }
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            },
            foreclosureSalesStatus() {
                if (this.community) {
                    if (this.community.sales_cycles) {
                        let filteredSalesStages = _.filter(this.community.sales_cycles, function (o) {
                            return o.active && o.foreclosure;
                        });
                        if (filteredSalesStages.length > 0) {
                            return this.salesStatus(parseInt(filteredSalesStages[0].sales_stage))
                        } else {
                            return 0;
                        }
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            },
            rentalBadgeContent() {
                if (this.community) {
                    if (this.rentalPartner) {
                        if (this.rentalSalesStatus === 0) {
                            return '&#10004;'
                        } else {
                            return '&#10004;&#43;'
                        }
                    } else {
                        if (this.rentalSalesStatus === 0) {
                            return '';
                        } else {
                            return this.rentalSalesStatus;
                        }
                    }
                }
            },
            vacantBadgeContent() {
                if (this.community) {
                    if (this.vacantPartner) {
                        if (this.vacantSalesStatus === 0) {
                            return '&#10004;'
                        } else {
                            return '&#10004;&#43;'
                        }
                    } else {
                        if (this.vacantSalesStatus === 0) {
                            return '';
                        } else {
                            return this.vacantSalesStatus;
                        }
                    }
                }
            },
            foreclosureBadgeContent() {
                if (this.community) {
                    if (this.foreclosurePartner) {
                        if (this.foreclosureSalesStatus === 0) {
                            return '&#10004;'
                        } else {
                            return '&#10004;&#43;'
                        }
                    } else {
                        if (this.foreclosureSalesStatus === 0) {
                            return '';
                        } else {
                            return this.foreclosureSalesStatus;
                        }
                    }
                }
            },
            contractExpiration() {
                let closestExpiration = null;
                let programs = [];
                if (this.community) {
                    if (this.community.contracts) {
                        if (this.community.contracts.length === 0) {
                            return ': No Active Contracts'
                        }
                        if (this.community.contracts.length === 1) {
                            closestExpiration = this.community.contracts[0]
                        } else {
                            closestExpiration = this.closestFromNow(this.community.contracts);
                            console.log(closestExpiration);
                        }
                        if (closestExpiration.foreclosure) {
                            programs.push('Foreclosure')
                        }
                        if (closestExpiration.vacant) {
                            programs.push('Vacant')
                        }
                        if (closestExpiration.rental) {
                            programs.push('Rental')
                        }
                        if (moment(closestExpiration.expiration_date).isBefore(moment(), "day")) {
                            return " (" + programs.join(', ') + "):<span class=\"expired\">  Expired " + moment(closestExpiration.expiration_date).fromNow() + '</span>'
                        } else {
                            return " (" + programs.join(', ') + "):<span class=\"expires\">  Expires " + moment(closestExpiration.expiration_date).fromNow() + '</span>'
                        }
                    } else {
                        return ': No Active Contracts'
                    }
                } else {
                    return null
                }
            },
            governance() {
                if (this.community) {
                    if (this.community.state) {
                        switch (parseInt(this.community.state.state_governance)) {
                            case 1:
                                return 'Home Rule';
                            case 2:
                                return 'Dillon\'s Rule';
                            case null:
                                return 'N/A';
                            default:
                                return 'N/A';
                        }
                    } else {
                        return '';
                    }
                } else {
                    return null
                }
            },
            fcProcess() {
                if (this.community) {
                    if (this.community.state) {
                        switch (parseInt(this.community.state.state_foreclosure_process)) {
                            case 1:
                                return 'Judicial';
                            case 2:
                                return 'Non-Judicial';
                            case null:
                                return 'N/A';
                            default:
                                return 'N/A';
                        }
                    } else {
                        return '';
                    }
                } else {
                    return null
                }
            },
            relationshipStatusClass() {
                if (this.community) {
                    if (this.community.sales_configuration) {
                        switch (this.community.sales_configuration.relationship_status) {
                            case 1:
                                return 'icon-alert-red sprite';
                            case 2:
                                return 'icon-alert-yellow sprite';
                            case 3:
                                return 'icon-alert-green sprite';
                            case null:
                                return 'hidden'
                        }
                    }
                }
            },
            brandingStatusClass() {
                if (this.community) {
                    if (this.community.branding_configuration) {
                        if (this.community.branding_configuration.redirect_url
                            && this.community.branding_configuration.redirect_email
                            && this.community.branding_configuration.redirect_phone
                        ) {
                            return 'icon-alert-green sprite'
                        } else {
                            return 'icon-alert-yellow sprite'
                        }
                    } else {
                        return 'icon-alert-yellow sprite'
                    }
                }
            },
            kebabFullName() {
                if (this.community) {
                    return _.kebabCase(this.community.FULLNAME)
                } else {
                    return nulL;
                }
            },
            kebabCounty() {
                if (this.community) {
                    return _.kebabCase(this.community.COUNTY)
                } else {
                    return null;
                }
            },
            shareLink: function () {
                if (this.community) {
                    return "https://community.prochamps.com/" + this.community.STATE + "/" + this.kebabCounty + "/" + this.kebabFullName;
                } else {
                    return ""
                }
            },
            rentalShareLink: function () {
                if (this.shareLink !== "" || this.shareLink !== null) {
                    return this.shareLink + "/rental";
                } else {
                    return ""
                }
            },
            vacantShareLink: function () {
                if (this.shareLink !== "" || this.shareLink !== null) {
                    return this.shareLink + "/vacant";
                } else {
                    return ""
                }
            },
            foreclosureShareLink: function () {
                if (this.shareLink !== "" || this.shareLink !== null) {
                    return this.shareLink + "/foreclosure";
                } else {
                    return ""
                }
            },
            communityExclusion() {
                if (this.community) {
                    if (this.community.sales_configuration) {
                        if (this.community.sales_configuration.excluded) {
                            return 'Yes'
                        } else {
                            return 'No'
                        }
                    } else {
                        return 'No'
                    }
                } else {
                    return null
                }
            },
            specialOversight() {
                if (this.community) {
                    if (this.community.sales_configuration) {
                        return !!this.community.sales_configuration.special_oversight;
                    } else {
                        return false
                    }
                } else {
                    return null
                }
            },
            strongMayor() {
                if (this.community) {
                    if (this.community.sales_configuration) {
                        if (this.community.sales_configuration.strong_mayor) {
                            return 'Yes'
                        } else {
                            if (this.community.sales_configuration.strong_mayor === false) {
                                return 'No'
                            } else {
                                return 'N/A'
                            }
                        }
                    } else {
                        return "N/A"
                    }
                } else {
                    return null
                }
            },
            stateExcluded() {
                if (this.community) {
                    if (this.community.state.excluded) {
                        return 'Yes'
                    } else {
                        return 'No'
                    }
                } else {
                    return null
                }
            },
            size(quartile) {
                if (this.community ? this.community.housing_data : null) {
                    switch (parseInt(this.community.housing_data.quartile)) {
                        case 0:
                            return 'X-Small';
                        case 1:
                            return 'Small';
                        case 2:
                            return 'Medium';
                        case 3:
                            return 'Large';
                        case 4:
                            return 'X-Large';
                        default:
                            return 'X-Small';
                    }
                } else {
                    return null;
                }
            },
            logoUrl() {
                if (this.community) {
                    if (this.community.community_logo) {
                        return encodeURI('https://s3.amazonaws.com/communitymanagement/' + this.community.community_logo.logo);
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }
            },
            communitycode() {
                if (this.community) {
                    return this.community.CODE;
                } else {
                    return null;
                }
            }
        },
        methods: {
            communityOpen(idn) {
                if($('#'+idn+'Info').is(':visible')) {
                    $('.openInfo').slideUp('fast');
                    $('#'+idn+'Info').slideUp('fast');
                }else{
                    $('.openInfo').slideUp('fast');
                    $('#'+idn+'Info').slideDown('fast');
                }
            },
            csInfoToggleClick() {
                $('#csInfoToggle').slideToggle();
                $('.customHeadRightArrow').toggleClass("down") ;
            },
            countyCityToggle() {
                $('.cardCustomBody').slideToggle();
                $('.rotate').toggleClass("down") ;
            },
            closeAlertMessage(){
                $('.communityWarning').hide();
            },
            openTabContent(content, tab){
                $('.tabContent').hide();
                $('.tabCustom').removeClass('tabCustomClicked');
                $(`#${content}`).show();
                $(`#${tab}`).addClass('tabCustomClicked');
            },
            openTaskTabContent(content, tab){
                $('.taskTabContent').hide();
                $('.taskTabCustom').removeClass('taskTabClicked');
                $(`#${content}`).show();
                $(`#${tab}`).addClass('taskTabClicked');
            },
            taskTabToggle(id){
                console.log('Clicked', id);
                $(`#${id}`).slideToggle();
            },
            asanaNewTask(id){
                $(`.asanaNewTaskCreate-${id}`).toggle();
                $(`#asanaNewTaskCreateInput-${id}`).focus();
            },
            openUserDiv(){
                console.log('show')
                $('#openUserDiv').show();
            },
            getTaskTabContent(){
                const that = this;
                const asanaLocalProjs = localStorage.getItem('asanaProjects') === null  ? {} : JSON.parse(localStorage.getItem('asanaProjects'));
                this.asanaLoading = true;
                Nova.request().get('/api/asana/tab?osusr_mlv_community_id=' + this.resourceId).then(response => {
                    $('#copLoading').hide()
                    if(response.data.data == null){
                        this.asanaLoading = false;
                    }else{
                        response.data.data.map(proj =>{
                            const asanaProjKey = proj.gid;
                            const asanaProjData = proj;
                            asanaLocalProjs[asanaProjKey] = this.mergeRecursive(asanaProjData, asanaLocalProjs[asanaProjKey]);
    
                            this.getAsyncSection(proj.gid);
                        });
                        this.localAsana()
                        const asanaLocalStore = JSON.stringify(asanaLocalProjs);
                        localStorage.setItem('asanaProjects', asanaLocalStore);
                    }


                });
                this.getUsers();
                setTimeout(function () {
                    that.uiUpdateMounted()
                }, 500);
            },
            getAsyncSection(id){
                Nova.request().get(`/api/asana/tab/sections/${id}`).then(response => {
                    response.data.data.data.map(section => {
                        this.getAsyncTasks(section.gid, response.data.projectGid, 0);
                    });

                    const asanaLocalProjsSec = JSON.parse(localStorage.getItem('asanaProjects'));
                    asanaLocalProjsSec[response.data.projectGid].sections = this.mergeRecursive(response.data.data.data, asanaLocalProjsSec[response.data.projectGid].sections);
                    this.localAsana()
                    const asanaLocalStoreSec = JSON.stringify(asanaLocalProjsSec);
                    localStorage.setItem('asanaProjects', asanaLocalStoreSec);
                });
            },
            getAsyncTasks(sectionId, projectId, flag=0){
                Nova.request().get(`/api/asana/tab/tasks/${sectionId}`).then(response => {
                    const asanaLocalProjsTask = JSON.parse(localStorage.getItem('asanaProjects'));
                    console.log('Tasks response.data.data', response.data.data.length)
                    if(response.data.data.length == 0){
                        if(flag < 4){
                            console.log('flag', `${flag}-${sectionId}`)
                            setTimeout(() => {
                                this.getAsyncTasks(sectionId, projectId, ++flag);
                            }, 20000);
                        }
                    }
                    asanaLocalProjsTask[projectId].sections.map(sec => {
                        if(sec.gid == sectionId){
                            sec.tasks = response.data.data;
                            return sec;
                        }else{
                            return sec;
                        }
                    });
                    this.localAsana()
                    const asanaLocalStoreTask = JSON.stringify(asanaLocalProjsTask);
                    localStorage.setItem('asanaProjects', asanaLocalStoreTask);
                });
            },
            localAsana(){
                const asanaLocalProjs = JSON.parse(localStorage.getItem('asanaProjects'));
                if(asanaLocalProjs !== null){
                    if(Object.keys(asanaLocalProjs).length > 0){
                        var acoProjects = []
                        Object.keys(asanaLocalProjs).map(localProj =>{
                            if(asanaLocalProjs[localProj].comminity_id == this.resourceId){
                                acoProjects.push(asanaLocalProjs[localProj]);
                            }
                        });
                        this.asana = acoProjects;
                    }
                }
            },
            getUsers(){
                Nova.request().get('/api/asana/tab/users').then(response => {
                    this.asanaUsers = response.data.data;
                });
            },
            asanaTaskCreateOnSubmit(asan){
                const that = this;
                $(`.asanaTaskOnSubmit${asan.gid}`).keydown(function (e) {
                    if (e.keyCode == 13) {
                        that.asanaStoreTask(asan);
                    }
                });
            },
            asanaStoreTask(asan) {
                $(`.asanaNewTaskCreate-${asan.gid}`).toggle();
                this.asanaTaskCreate.projects = [asan.gid];
                this.asanaTaskCreate.workspace = asan.workspace_id;
                if(this.asanaTaskCreate.name == ''){
                    console.log('No task Name');
                }else{
                    $('.newTaskButton').addClass('fa-spin');
                    Nova.request().post('/api/asana/tab/tasks/store', this.asanaTaskCreate).then(response => {
                        $('.newTaskButton').removeClass('fa-spin');
                        if (response.data.status === 200) {
                            this.asanaTaskCreate.name = '';
                            const addedSection = response.data.data.data.memberships[0].section.gid;
                            const asanaLocalProjsNewTask = JSON.parse(localStorage.getItem('asanaProjects'));
                            const taskObj = {
                                details: {
                                    gid: response.data.data.data.gid,
                                    name: response.data.data.data.name,
                                    resource_type: response.data.data.resource_type
                                },
                                subTasks: 0,
                                comments: 0,
                                completed: response.data.data.data.completed,
                                assignee: response.data.data.data.assignee ? response.data.data.data.assignee : {gid: null, name: null,resource_type: 'user'},
                                duedate:  response.data.data.data.due_on
                            }
                            asanaLocalProjsNewTask[asan.gid].sections.map(sec => {
                                if(sec.gid == addedSection){
                                    sec.tasks.unshift(taskObj);
                                }
                            });
                            const asanaLocalStoreNewTask = JSON.stringify(asanaLocalProjsNewTask);
                            localStorage.setItem('asanaProjects', asanaLocalStoreNewTask);
                            this.localAsana();
                        } else {
                            this.errors = response.data.errors;
                        }
                    });
                }
                
            },
            asanaEditTask(task, prop, e) {
                const taskUp = {
                    gid: task.details.gid
                }
                if(prop == 'completed'){
                    $(`#nameB-${task.details.gid}`).show();
                    $(`#nameC-${task.details.gid}`).hide();
                    taskUp.completed = task.completed;
                }
                if(prop == 'name'){
                    $(`#nameB-${task.details.gid}`).show();
                    $(`#nameC-${task.details.gid}`).hide();
                    taskUp.name = e.target.value;
                }
                if(prop == 'assignee'){
                    $(`#assigneeB-${task.details.gid}`).show();
                    $(`#assigneeC-${task.details.gid}`).hide();
                    taskUp.assignee = e.target.value;
                }
                if(prop == 'dueOn'){
                    $(`#dueOnB-${task.details.gid}`).show();
                    $(`#dueOnC-${task.details.gid}`).hide();
                    taskUp.due_on = this.convert(e);
                }
                this.asanaUpdateTask(taskUp, prop);
            },
            asanaUpdateTask(task, prop) {
                Nova.request().post('/api/asana/tab/tasks/update/' + task.gid, task).then(response => {
                    if (response.data.status === 200) {
                        if(prop == 'completed'){
                            $(`#nameB-${task.gid}`).hide();
                            $(`#nameC-${task.gid}`).show();
                        }
                        if(prop == 'name'){
                            $(`#nameB-${task.gid}`).hide();
                            $(`#nameC-${task.gid}`).show();
                        }
                        if(prop == 'assignee'){
                            $(`#assigneeB-${task.gid}`).hide();
                            $(`#assigneeC-${task.gid}`).show();
                        }
                        if(prop == 'dueOn'){
                            $(`#dueOnB-${task.gid}`).hide();
                            $(`#dueOnC-${task.gid}`).show();
                        }
                        console.log(response);
                        const project = response.data.data.data.projects[0].gid;
                        const addedSection = response.data.data.data.memberships[0].section.gid;

                        const asanaLocalProjsNewTask = JSON.parse(localStorage.getItem('asanaProjects'));
                        asanaLocalProjsNewTask[project].sections.map(sec => {
                            if(sec.gid == addedSection){
                                sec.tasks.map(task => {
                                    if(task.details.gid == response.data.data.data.gid){
                                        task.completed = response.data.data.data.completed;
                                        task.details.name = response.data.data.data.name;
                                        task.assignee = response.data.data.data.assignee ? response.data.data.data.assignee : {gid: null, name: null,resource_type: 'user'};
                                        task.duedate = response.data.data.data.due_on;
                                    }
                                })
                            }
                        });
                        const asanaLocalStoreNewTask = JSON.stringify(asanaLocalProjsNewTask);
                        localStorage.setItem('asanaProjects', asanaLocalStoreNewTask);
                        this.localAsana();
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            asanaFilterTask(proj, block, e){
                
                $(`.taskSectionHolder-${proj}`).children().show();

                if(block == 'complited'){
                    if(e.target.value != 'null'){
                        $(`.taskSectionHolder-${proj}`).children()
                            .filter(function(){
                                console.log('In', e.target.value)
                                console.log($(this).data('complited'))
                                return $(this).data('complited')+'' != e.target.value;
                        }).hide();
                    }                
                }
                if(block == 'assignee'){
                    if(e.target.value != 'null'){
                        $(`.taskSectionHolder-${proj}`).children()
                            .filter(function(){
                                return $(this).data('assignee') != e.target.value;
                        }).hide();
                    }                
                }
                if(block == 'due'){
                    if(e.target.value != 'null'){
                        var that = this;
                        $(`.taskSectionHolder-${proj}`).children()
                            .filter(function(){
                                let diff = 0;
                                if($(this).data('due') != null){
                                    var dtx = new Date($(this).data('due'));
                                    let dtxDate = dtx.getFullYear() + "/" + (dtx.getMonth() + 1) + "/" + dtx.getDate();
                                    var dt = new Date();
                                    let now = dt.getFullYear() + "/" + (dt.getMonth() + 1) + "/" + dt.getDate();

                                    let dateA = that.parseDate(dtxDate);
                                    let dateB = that.parseDate(now);

                                    diff = that.datediff(dateB, dateA);
                                    console.log("$(this).data('due')", $(this).data('due'));
                                    console.log('e.target.value', e.target.value);
                                    console.log('Diff', diff);
                                    console.log('===========================================');
                                    return e.target.value <= diff || diff < 0;
                                }else{
                                    return true;
                                }
                        }).hide();
                    }                
                }
            },
            srchAsanaTask(proj, e){
                let keyWord = e.target.value;
                if(keyWord.length > 0){
                    $(`.taskSectionHolder-${proj}`).children()
                        .filter(function(){
                            const inStr = $(this).data('name').toLowerCase();
                            const srchStr = keyWord.toLowerCase();
                            return inStr.search(srchStr) == -1;
                    }).hide();
                }else{
                    $(`.taskSectionHolder-${proj}`).children().show();
                }
            },
            parseDate(str) {
                var mdy = str.split('/');
                return new Date(str);
            },
            datediff(first, second) {
                return Math.round((second-first)/(1000*60*60*24));
            },
            // Up
            navigateToChanges() {
                window.scrollTo(0, document.body.scrollHeight);
                document.querySelector("#nova > div > div.content > div.px-view.py-view.mx-auto > div > div.relative > div:nth-child(5) > div > div > div.tabs-wrap.border-b-2.border-40.w-full > div > button:nth-child(6)").click()
            },
            getPendingChangeCount() {
                Nova.request().post('/nova-vendor/community-summary/pendingChanges', {
                    communityId: this.resourceId
                }).then(response => {
                    this.pendingChanges = response.data
                });
            },
            closestFromNow(times) {
                const m = new Map(times.map(x => {
                    let date = new Date(x.expiration_date);
                    if (!this.isBeforeNow(date)) date = this.generateKey(date);
                    else date = undefined;
                    return [date, x]
                }));
                m.delete(undefined);
                return m.get(Math.min(...m.keys()))
            },
            isBeforeNow(x) {
                return Date.now() > x;
            },
            generateKey(x) {
                return Math.abs(Date.now() * 1 - x * 1)
            },
            displayLink() {
                Swal.fire({
                    title: "Community Share Links",
                    html: `
                        <div>
                            <span>${this.shareLink}</span>
                            <br>
                            <span>${this.rentalShareLink}</span>
                            <br>
                            <span>${this.vacantShareLink}</span>
                            <br>
                            <span>${this.foreclosureShareLink}</span>
                        </div>
                    `,
                    width: 800,
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'Close'
                })
            },
            viewCore() {
                window.open('https://apps.prochamps.com/CORE/Community_Detail.aspx?CommunityId=' + this.resourceId, '_blank');
            },
            viewSharepoint() {
                window.open('https://communitychampions.sharepoint.com/sites/PROCHAMPS/Shared Documents/Forms/Community List.aspx?viewid=aab0c87c-fcc5-48bb-b1bf-51373b14dc51&id=/sites/PROCHAMPS/Shared Documents/Community/' + this.communitycode, '_blank');
            },
            viewRPLanding() {
                window.open('https://www.prochamps.com/Prochamps/ComProp.aspx?CommunityId=' + this.resourceId, '_blank');
            },
            salesStatus(statusId) {
                if (this.community) {
                    switch (parseInt(statusId)) {
                        case 1:
                            return '';
                        case 13:
                            return '1';
                        case 11:
                            return '2';
                        case 12:
                            return '3';
                        case 6:
                            return '4';
                        case 5:
                            return '5';
                        case 14:
                            return '6';
                        default:
                            return '';
                    }
                } else {
                    return null;
                }
            },
            salesStatusClass(statusId) {
                if (this.community) {
                    switch (parseInt(statusId)) {
                        case 1:
                            return 'round-info gold-n0';
                        case 13:
                            return 'round-info gold-n1';
                        case 11:
                            return 'round-info gold-n2';
                        case 12:
                            return 'round-info gold-n3';
                        case 6:
                            return 'round-info gold-n4';
                        case 5:
                            return 'round-info-green gold-n5';
                        case 14:
                            return 'round-info gold-n6';
                        default:
                            return 'round-info gold-n0';
                    }
                } else {
                    return null;
                }
            },
            getLatestActivity() {
                Nova.request().post('/nova-vendor/community-summary/latestActivity', {
                    communityId: this.resourceId
                }).then(response => {
                    console.log(response.data);
                    this.latestActivity = response.data
                });
            },
            mergeRecursive(obj1, obj2) {
                for (var p in obj2) {
                    try {
                    // Property in destination object set; update its value.
                    if ( obj2[p].constructor==Object ) {
                        obj1[p] = MergeRecursive(obj1[p], obj2[p]);
                    } else {
                        obj1[p] = obj2[p];
                    }
                    } catch(e) {
                    // Property in destination object not set; create it and set its value.
                    obj1[p] = obj2[p];
                    }
                }
                return obj1;
            },
            createProject() {
                $('#cpLoading').show()
                this.isLoading = true;
                this.project.name = this.community.STATE + '-' + this.community.COUNTY + '-' + this.community.FRIENDLYNAME + '-' + this.community.COMMUNITYID + '-Standard';

                window.location.href = window.location.origin+"/accessToken/"+JSON.stringify(this.project);
                return false;
                
                Nova.request().post('/api/asana/project/store', this.project).then(response => {
                    this.isLoading = false;

                    if (response.data.status === 200) {
                        
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            storeTask() {
                this.isLoading = true;

                console.log(this.task);

                Nova.request().post('/api/asana/task/store', this.task).then(response => {
                    this.isLoading = false;
                    this.createNewTask = false;
                    console.log(response.data);

                    if (response.data.status === 200) {
                        
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            createTaskOnSubmit(){
                console.log('In Methods');
                const that = this
                $(".createTaskOnSubmit").keydown(function (e) {
                    console.log('Typed Something');
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        console.log("Pressed Enter");
                        that.storeTask();
                    }
                });
            },
            showTask(id) {
                this.sideBar = 1;
                this.taskParents = [];
                $('.loader-io').css('display', 'flex');
                $('.task-details-wrapper').hide();

                Nova.request().get('/api/asana/task/details/' + id).then(response => {
                    $('.loader-io').hide();
                    $('.task-details-wrapper').show();

                    if (response.status == 200) {
                        this.taskDetails = response.data.data;
                        console.log(this.taskDetails[0]);
                        const project = response.data.data[0].data.projects[0].gid;
                        const secSelId = response.data.data[0].data.memberships[0].section.gid;
                        console.log('project', project);
                        let asanaSections = {}
                        this.asana.map(as => {
                            if(as.gid == project){
                                as.sections.map((sec, i) => {
                                    const secSel = secSelId == sec.gid ? true : false;
                                    asanaSections[sec.gid] = {gid:sec.gid, name:sec.name,selected:secSel}
                                    console.log('sec.name', sec.name);
                                })
                            }
                        })
                        console.log('asanaSections', asanaSections);
                        this.detSections = asanaSections;
                    } else {
                        this.errors = response.data.msg.errors;
                    }
                });
            },
            editTask(id, key, e, sectionIndex, taskIndex) {
                this.isLoading = true;
                this.taskUpdate = {};
                this.taskUpdate.id = id;

                if (key == 'name') {
                    this.taskUpdate.name = e.target.value;
                    this.sectionData[sectionIndex]['tasks'][taskIndex][0].data.name = e.target.value;
                } else if (key == 'assignee') {
                    this.taskUpdate.assignee = e.gid;
                    this.sectionData[sectionIndex]['tasks'][taskIndex][0].data.assignee = e;
                    setTimeout(function () {
                        $('.nv-dropdown').removeClass('nv-open');
                    }, 100);
                } else if (key == 'completed') {
                    if (e.target.checked) {
                        this.taskUpdate.completed = true;
                        this.sectionData[sectionIndex]['tasks'][taskIndex][0].data.completed = true;
                    } else {
                        this.taskUpdate.completed = false;
                        this.sectionData[sectionIndex]['tasks'][taskIndex][0].data.completed = false;
                    }
                } else if (key == 'due_on') {
                    this.taskUpdate.due_on = this.convert(e);
                    this.sectionData[sectionIndex]['tasks'][taskIndex][0].data.due_on = this.convert(e);
                }

                this.updateTask();
            },
            updateTask() {
                let _this = this;
                this.taskUpdate._method = "PUT";
                console.log(this.taskUpdate);

                Nova.request().post('/api/asana/task/update/' + this.taskUpdate.id, this.taskUpdate).then(response => {
                    this.isLoading = false;

                    setTimeout(function () {
                        _this.uiUpdateMounted()
                    }, 500);

                    if (response.data.status === 200) {
                        this.taskUpdate = {};
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            inlineTaskUpdate(section = null, id, name, e) {
                $('.task-details-wrapper').hide();
                $('.loader-io').css('display', 'flex');
                $('#openUserDiv').hide();

                let formData = new FormData();
                formData.append('_method', 'PUT');

                if (name == 'completed') {
                    if (e.target.checked) {
                        formData.append(name, true);
                        this.taskDetails[0].data.completed = true;
                    } else {
                        formData.append(name, false);
                        this.taskDetails[0].data.completed = false;
                    }
                }  else if (name == 'due_on') {
                    formData.append(name, this.convert(e));
                }  else if (name == 'assignee') {
                    formData.append(name, e.gid);
                    setTimeout(function () {
                        $('.nv-dropdown').removeClass('nv-open');
                    }, 100);
                } else {
                    formData.append(name, e.target.value);
                }


                Nova.request().post('/api/asana/task/update/' + id, formData).then(response => {
                    console.log('Response', response);
                    $('.loader-io').hide();
                    $('.task-details-wrapper').show();

                    if (response.data.status === 200) {
                        if (name == 'name') {
                            this.taskDetails[0].data.name = e.target.value;
                        } else if(name == 'notes') {
                            this.taskDetails[0].data.notes = e.target.value;
                        } else if(name == 'due_on') {
                            this.taskDetails[0].data.due_on = this.convert(e);
                        } else if (name == 'section') {
                            this.taskDetails[0].data.memberships[0].section.gid = e.target.value;
                            this.taskDetails[0].data.memberships[0].section.name = e.target.options[e.target.selectedIndex].text;
                            
                        }  else if (name == 'assignee') {
                            this.taskDetails[0].data.assignee = e;
                        }
                        const project = response.data.data.data.projects[0].gid;
                        const addedSection = response.data.data.data.memberships[0].section.gid;


                        const asanaLocalProjsNewTask = JSON.parse(localStorage.getItem('asanaProjects'));
                        asanaLocalProjsNewTask[project].sections.map(sec => {
                            if (name == 'section') {
                                if(sec.gid == section){
                                    sec.tasks.map((task, i) => {
                                        if(task.details.gid == id){
                                            asanaLocalProjsNewTask[project].sections.map(sa => {
                                                if(sa.gid == addedSection){
                                                    sa.tasks.unshift(sec.tasks[i])
                                                }
                                            })
                                            sec.tasks.splice(i, 1);
                                        }
                                    })
                                }
                            }else{
                                if(sec.gid == addedSection){
                                    sec.tasks.map(task => {
                                        if(task.details.gid == response.data.data.data.gid){
                                            task.completed = response.data.data.data.completed;
                                            task.details.name = response.data.data.data.name;
                                            task.assignee = response.data.data.data.assignee ? response.data.data.data.assignee : {gid: null, name: null,resource_type: 'user'};
                                            task.duedate = response.data.data.data.due_on;
                                        }
                                    })
                                }
                            }
                        });
                        const asanaLocalStoreNewTask = JSON.stringify(asanaLocalProjsNewTask);
                        localStorage.setItem('asanaProjects', asanaLocalStoreNewTask);
                        this.localAsana();
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            deleteTask(task) {
                // task.gid replaced with task
                let THIS = this;

                Swal.fire({
                    type: 'error',
                    title: 'Delete Task',
                    text: 'Are you sure want to delete this data?',
                    showCancelButton: true,
                    focusConfirm: true
                }).then(res => {
                    if(res.value !== undefined){
                        this.isLoading = true;

                        $(`#nameB-${task.gid}`).show();
                        $(`#nameC-${task.gid}`).hide();
                        $(`#assigneeB-${task.gid}`).show();
                        $(`#assigneeC-${task.gid}`).hide();
                        $(`#dueOnB-${task.gid}`).show();
                        $(`#dueOnC-${task.gid}`).hide();

                        Nova.request().post('/api/asana/task/destroy/' + task.gid, {_method: 'DELETE'}).then(response => {
                            this.isLoading = false;

                            if (response.data.status === 200) {
                                

                                const project = task.projects[0].gid;
                                const addedSection = task.memberships[0].section.gid;

                                const asanaLocalProjsNewTask = JSON.parse(localStorage.getItem('asanaProjects'));
                                asanaLocalProjsNewTask[project].sections.map(sec => {
                                    if(sec.gid == addedSection){
                                        sec.tasks.map((tsk, i) => {
                                            if(tsk.details.gid == task.gid){
                                                sec.tasks.splice(i, 1);
                                            }
                                        })
                                    }
                                });
                                const asanaLocalStoreNewTask = JSON.stringify(asanaLocalProjsNewTask);
                                localStorage.setItem('asanaProjects', asanaLocalStoreNewTask);
                                this.localAsana();
                            } else {
                                THIS.errors = response.data.errors;
                            }
                        });
                    }
                });
            },
            handleFileUpload(id, e){
                $('.loader-io').css('display', 'flex');
                $('.task-details-wrapper').hide();

                /*
                Handles a change on the file upload
               */
                this.file = e.target.files[0];

                /*
                Initialize the form data
                */
                let formData = new FormData();

                /*
                    Add the form data we need to submit
                */
                formData.append('file', this.file);

                /*
                  Make the request to the POST /single-file URL
                */
                Nova.request().post( '/api/asana/task/attachment/' + id,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function(response){
                    $('.loader-io').hide();
                    $('.task-details-wrapper').show();

                    e.target.value = "";

                    if (response.data.status == 200) {
                        Swal.fire({
                            type: 'success',
                            position: 'top-end',
                            title: 'Attachment uploaded successfully.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'FAILURE!!',
                            text: 'Upload failed.',
                            showCancelButton: true,
                            focusConfirm: true
                        });
                    }
                }).catch(function(){
                    $('.loader-io').hide();
                    $('.task-details-wrapper').show();

                    Swal.fire({
                        type: 'error',
                        title: 'FAILURE!!',
                        text: 'Upload failed.',
                        showCancelButton: true,
                        focusConfirm: true
                    });
                });
            },
            convert(str) {
                var date = new Date(str),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                return [date.getFullYear(), mnth, day].join("-");
            },
            createSubTask(task) {
                $('.task-details-wrapper').hide();
                $('.loader-io').css('display', 'flex');
                this.subTask.project = task.projects[0].gid;
                console.log('this.subTask', this.subTask);

                Nova.request().post('/api/asana/task/' + task.gid + '/subtasks', this.subTask).then(response => {
                    $('.loader-io').hide();
                    $('.task-details-wrapper').show();

                    if (response.data.status === 200) {
                        console.log('subtasks', response);
                        this.createNewSubTask = false;
                        this.taskDetails.subTasks.push(response.data.data);
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            duedate(date) {
                if (date) {
                    // To set two dates to two variables
                    var date1 = new Date();
                    var date2 = new Date(date);

                    // To calculate the time difference of two dates
                    var Difference_In_Time = date2.getTime() - date1.getTime();

                    // To calculate the no. of days between two dates
                    var Difference_In_Days = Math.floor(Difference_In_Time / (1000 * 3600 * 24));

                    if (Math.sign(Difference_In_Days) === 1) {
                        return 'Due in ' + Difference_In_Days + ' day(s)';
                    } else if(Math.sign(Difference_In_Days) === -1) {
                        return 'Overdue';
                    }else {
                        return 'Today';
                    }
                } else {
                    return 'N/A';
                }
            },
            inlineSubTaskUpdate(id, index, name, e) {
                $('.task-details-wrapper').hide();
                $('.loader-io').css('display', 'flex');

                this.subTaskUpdate = {};
                this.subTaskUpdate.id = id;
                this.subTaskUpdate._method = 'put';

                if (name == 'completed') {
                    if (e.target.checked) {
                        this.subTaskUpdate.completed = true;
                        this.taskDetails.subTasks[index][0].data.completed = true;
                    } else {
                        this.subTaskUpdate.completed = false;
                        this.taskDetails.subTasks[index][0].data.completed = false;
                    }
                } else if (name == 'due_on') {
                    this.subTaskUpdate.due_on = this.convert(e);
                } else if (name == 'assignee') {
                    this.subTaskUpdate.assignee = e.gid;
                } else if (name == 'name') {
                    this.subTaskUpdate.name = e.target.value;
                } else if(name == 'notes') {
                    this.subTaskUpdate.notes = e.target.value;
                }

                Nova.request().post('/api/asana/task/update/' + this.subTaskUpdate.id, this.subTaskUpdate).then(response => {
                    $('.loader-io').hide();
                    $('.task-details-wrapper').show();

                    if (response.data.status === 200) {
                        if (name == 'name') {
                            this.taskDetails.subTasks[index][0].data.name = e.target.value;
                        } else if(name == 'notes') {
                            this.taskDetails.subTasks[index][0].data.notes = e.target.value;
                        } else if(name == 'due_on') {
                            this.taskDetails.subTasks[index][0].data.due_on = this.convert(e);
                        } else if (name == 'section') {
                            this.taskDetails.subTasks[index][0].data.memberships[0].section.gid = e.target.value;
                            this.taskDetails.subTasks[index][0].data.memberships[0].section.name = e.target.options[e.target.selectedIndex].text;
                        }  else if (name == 'assignee') {
                            this.taskDetails.subTasks[index][0].data.assignee = e;
                        }
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            storeTaskComment(id) {
                $('.loader-io').css('display', 'flex');
                $('.task-details-wrapper').hide();

                Nova.request().post('/api/asana/task/' + id + '/stories', {taskComment: this.taskComment}).then(response => {
                    $('.loader-io').hide();
                    $('.task-details-wrapper').show();

                    if (response.data.status === 200) {
                        this.taskComment = '';
                        console.log('this.taskDetails', this.taskDetails);
                        console.log('response.data.data', response.data.data);
                        this.taskDetails.comments = response.data.data.data;
                        Swal.fire({
                            type: 'success',
                            position: 'top-end',
                            title: 'Comment added successfully.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        if (response.data.errors) {
                            this.errors = response.data.errors;
                        }

                        Swal.fire({
                            type: 'error',
                            title: 'FAILURE!!',
                            text: 'Addition failed.',
                            showCancelButton: true,
                            focusConfirm: true
                        });
                    }
                });
            },
            showChildTask(id, parentId, parentName) {
                this.taskParents.push({
                    id: parentId,
                    name: parentName
                });
                $('.loader-io').css('display', 'flex');
                $('.task-details-wrapper').hide();

                this.taskDetails = null;
                Nova.request().get('/api/asana/task/details/' + id).then(response => {
                    $('.loader-io').hide();
                    $('.task-details-wrapper').show();

                    if (response.status == 200) {
                        this.taskDetails = response.data.data;
                    } else {
                        this.errors = response.data.msg.errors;
                    }
                });
            },
            showParentTask(id, index) {
                if (this.taskParents.length == 1) {
                    this.taskParents = [];
                } else {
                    if (index == 0) {
                        this.taskParents = [];
                    } else if (this.taskParents.length - 1 == index) {
                        this.taskParents.pop();
                    } else {
                        this.taskParents.splice(index, this.taskParents.length - index);
                    }
                }
                $('.loader-io').css('display', 'flex');
                $('.task-details-wrapper').hide();

                this.taskDetails = null;
                Nova.request().get('/api/asana/task/details/' + id).then(response => {
                    $('.loader-io').hide();
                    $('.task-details-wrapper').show();

                    if (response.status == 200) {
                        this.taskDetails = response.data.data;
                    } else {
                        this.errors = response.data.msg.errors;
                    }
                });
            },
            uiUpdateMounted: function () {
                let _this = this;

                $('.main-wrapper').on('keyup', '.drop-down-input', function () {
                    $('.nv-dropdown-under-input').removeClass('nv-open-under-input');
                    $(this).closest('.nv-dropdown-under-input').addClass('nv-open-under-input');
                });

                $('.main-wrapper').on('click', '.each-assignee-under-input', function () {
                    setTimeout(function () {
                        $('.nv-dropdown').removeClass('nv-open');
                        $('.nv-dropdown-under-input').removeClass('nv-open-under-input');
                    }, 200);
                });

                $('.tab-content').on('click', '.nv-dropdown', function () {
                    $('.nv-dropdown').removeClass('nv-open');
                    $(this).addClass('nv-open');
                    $(this).find('input').focus();
                });

                $(window).on('mouseup', function(e){
                    var clicked = $(e.target);
                    var clickTarget = clicked.closest('.nv-dropdown');
                    if(clickTarget.length === 0){
                        $('.nv-dropdown').removeClass('nv-open');
                        $('.nv-dropdown-under-input').removeClass('nv-open-under-input');
                    }
                    var sideBar = clicked.closest('#task-detail');
                    if(sideBar.length === 0){
                        _this.sideBar = 0;
                        _this.taskDetails = null;
                    }
                    $("#assignee-logo-id").removeClass("logo-hide");
                });
            },
            collapseDropdown(id) {
                this.task.assignee = id;

                setTimeout(function () {
                    $('.nv-dropdown').removeClass('nv-open');
                }, 100);
            },
            toogleComplete(id) {
                document.getElementById(id).click();
            },
            textSearch(e, flag) {
                var val = e.target.value.toLowerCase();

                if (flag) {
                    $(".name-text").each(function () {
                        var text = $(this).text().toLowerCase();

                        if (text.indexOf(val) == -1) {
                            $(this).closest('.each-assignee-under-input').hide();
                        } else {
                            $(this).closest('.each-assignee-under-input').css('display', 'inline-flex');
                        }
                    });
                } else {
                    $(".name-text").each(function () {
                        var text = $(this).text().toLowerCase();

                        if (text.indexOf(val) == -1) {
                            $(this).closest('.each-assignee').hide();
                        } else {
                            $(this).closest('.each-assignee').css('display', 'inline-flex');
                        }
                    });
                }
            },
            clearInput(e, flag) {
                setTimeout(function () {
                    e.target.value = '';
                    if (flag) {
                        $('.each-assignee-under-input').css('display', 'inline-flex');
                    } else {
                        $('.each-assignee').css('display', 'inline-flex');
                    }
                }, 1000);
            },
            storeNewTemplateProject() {
                $('#copLoading').show()
                this.isLoading = true;
                let formData = new FormData();
                formData.append('name', this.community.STATE + '-' + this.community.COUNTY + '-' + this.community.FRIENDLYNAME + '-' + this.community.COMMUNITYID + '-Onboarding');
                formData.append('osusr_mlv_community_id', this.community.COMMUNITYID);

                Nova.request().post('/api/asana/tab/duplicate', formData).then(response => {
                    this.isLoading = false;
                    if (response.data.status === 200) {
                        
                        this.getTaskTabContent();
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            }
        },
        created() {
            Nova.request().post('/nova-vendor/community-summary/community', {
                communityId: this.resourceId
            }).then(response => {
                console.log(response.data);
                this.community = response.data[0];
                this.loaded = true;
            });
            Nova.request().post('/nova-vendor/community-summary/foreclosures', {
                communityId: this.resourceId
            }).then(response => {
                this.estForeclosures = response.data;
            });
            this.getLatestActivity();
            this.getPendingChangeCount();

            function submitchat(){
                alert('Entered')
            }
        },
        mounted() {
            this.localAsana();
            this.getTaskTabContent();
        }
    }

    function submitchat(){
        alert('Entered')
    }
</script>

<style scoped>
    @import "../../static/css/main.css";
    @import "../../static/css/style.css";

    .expired {
        color: red;
    }

    .checkOkr {
        position: absolute;
        top: -8px;
        right: -20px;
        background-position: -58px -16px;
        width: 38px;
        height: 38px;
    }

    .checkOkv {
        position: absolute;
        top: -8px;
        right: -20px;
        background-position: -58px -16px;
        width: 38px;
        height: 38px;
    }

    .blank-image {
        padding-right: 90px;
    }

    .pointer {
        cursor: pointer;
    }
    .ph{
        padding: 20px 10px;
    }

    .rotate{
        -moz-transition: all .3s linear;
        -webkit-transition: all .3s linear;
        transition: all .3s linear;
    }
    .rotate.down{
        -moz-transform:rotate(180deg);
        -webkit-transform:rotate(180deg);
        transform:rotate(180deg);
    }
    .hoverUnderLine{
        font-size: 24px;
        -webkit-transition: all .5s;
        transition: all .5s;
        border-bottom: 1px solid;
        padding: 10px;
    }
    .hoverUnderLine:hover{
        color: #0a4c9e;
        cursor: pointer;
    }
    .cmOpenInfo{
        position: relative;
        color: #616f7f;
        padding: 5px 20px 5px;
    }
    .cmOpenInfo > span{
        font-size:18px;
        transition: all .5s;
    }
    .cmOpenInfo > span:hover{
        text-decoration: underline;
        color: #0a4c9e;
        cursor: pointer;
    }
</style>
