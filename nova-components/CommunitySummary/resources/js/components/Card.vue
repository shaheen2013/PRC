<template>
    <div class="mt-12">
        <loading-card :loading="!loaded" class="summary customSummary">
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i" rel="stylesheet">
            <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

            
            <div class="customHeader">
                <img v-if="this.community ? this.community.community_logo : null" :src="logoUrl" class="logoCommunity" alt="Logo of Community">
                <div v-if="this.community ? !this.community.community_logo : null" class="blank-image"></div>

                <div class="custHeadTop">
                    <div class="customHeadLeft">
                        <h1 class="headline">{{this.communityName}} <strong style="font-size: 13px;color: #9c9b9b;padding-left: 11px;">ID: {{this.community.COMMUNITYID}} </strong> </h1>
                    </div>
                    <div class="customHeadRight">
                        <h5 class="headline" style="font-size: 25px;color: #9c9b9b;">{{size}} | {{this.community ? (this.community.housing_data ?
                                        this.community.housing_data.housing_units : '') : ''}} Housing Units
                            <span><div class="fa-xs fas fa-sort-down rotate customHeadRightArrow" @click="csInfoToggleClick()" style="cursor:pointer;color:#0a4c9e"></div></span>
                        </h5>
                    </div>                    
                </div>
            </div>
            <section class="mt-11" id="csInfoToggle" style="padding: 0px 24px;">
                <div class="communityWarning">
                    <i class="fa-xs fas fa-exclamation-triangle exclamation-triangle" style="margin-right:10px;font-size: 30px;"></i> Some issue or alert message can go here.
                </div>                
                <header>
                    <div class="infoProgramsCustom" style="text-align:center">
                        <h4 class="infoCustomText">AT-RISK PROPERTY REGISTRATION</h4>
                        <div class="wrap-programs">
                            <div class="programsCustom customBorder">
                                <h3 class="text-center">Foreclosure<br><span class="text-xs text-80">{{parseInt(estForeclosures).toLocaleString()}}</span>
                                </h3>
                                <div v-html="foreclosureBadgeContent"
                                    :class="this.foreclosurePartner ? 'round-info-green gold-n5' : 'round-info gold-n0'"></div>
                            </div>
                            <div class="programsCustom customBorder">
                                <h3 class="text-center">Vacant<br><span class="text-xs text-80">{{this.community ? (this.community.housing_data ? parseInt(this.community.housing_data.est_vacant_total).toLocaleString() : 0) : 0}}</span>
                                </h3>
                                <div v-html="vacantBadgeContent"
                                    :class="this.vacantPartner ? 'round-info-green gold-n5' : 'round-info gold-n0'"></div>
                            </div>
                            <div class="programsCustom customBorder">
                                <h3 >RT Rental<br><span class="text-xs text-80">{{this.community ? (this.community.housing_data ? parseInt(this.community.housing_data.est_long_term_rental).toLocaleString() : 0) : 0}}</span></h3>
                                <div v-html="rentalBadgeContent"
                                    :class="this.rentalPartner ? 'round-info-green gold-n5' : 'round-info gold-n0'"></div>
                            </div>
                            <div class="programsCustom">
                                <h3 >ST Rental<br><span class="text-xs text-80">0.00</span></h3>
                                <div 
                                    :class="this.rentalPartner ? 'round-info gold-n0' : 'round-info gold-n0'"></div>
                            </div>
                        </div>
                        <h4 class="infoCustomText">Contract<span v-html="contractExpiration"></span></h4>
                    </div>
                </header>
                <div class="communityDetail" style="margin-top:20px;padding: 0px 50px;">
                    <div class="wrap-detailsBox">
                        <div class="">
                            <div class="wrap-detailBox">
                                <div>
                                    <div class="label-square hoverUnderLine" @click="communityOpen('co')">
                                        <h4><i class="fa-xs fas fa-square"></i>City of Jacksonville</h4>
                                    </div>
                                    <div class="openInfo cmOpenInfo" id="coInfo" style="display:none">
                                        <span @click="viewCore"><i class="fa-xs fas fa-square"></i> CORE</span>
                                        <br>
                                        <span @click="viewSharepoint"><i class="fa-xs fas fa-square"></i> Sharepoint </span>
                                        <br>
                                        <span @click="displayLink"><i class="fa-xs fas fa-square"></i> RP Landing</span>
                                        <br>
                                        <span><i class="fa-xs fas fa-square"></i> GOV Admin</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="label-square hoverUnderLine" @click="communityOpen('ty')">
                                        <h4><i class="fa-xs fas fa-square"></i>Duval County</h4>
                                    </div>
                                    <div class="openInfo cmOpenInfo" id="tyInfo" style="display:none">
                                        <span >
                                            <i class="fa-xs fas fa-square"></i> 
                                            County County Clerk
                                        </span>
                                        <br>
                                        <span>
                                            <i class="fa-xs fas fa-square"></i> 
                                            Property Appraiser 
                                        </span>
                                        <br>
                                        <span>
                                            <i class="fa-xs fas fa-square"></i> 
                                            Tax Accessor
                                        </span>
                                        <br>
                                        <span>
                                            <i class="fa-xs fas fa-square"></i> 
                                            Court Docket
                                        </span>
                                        <br>
                                        <span><i class="fa-xs fas fa-square"></i> Link to filter community list by county </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="label-square hoverUnderLine" @click="communityOpen('fl')">
                                        <h4><i class="fa-xs fas fa-square"></i>Florida</h4>
                                    </div>
                                    <div class="openInfo cmOpenInfo" id="flInfo" style="display:none">
                                        <span>
                                            <i class="fa-xs fas fa-square"></i> 
                                            Governance 
                                        </span>
                                        <br>
                                        <span>
                                            <i class="fa-xs fas fa-square"></i> 
                                            Foreclosure Process 
                                        </span>
                                        <br>
                                        <span>
                                            <i class="fa-xs fas fa-square"></i> 
                                            Exclude 
                                        </span>
                                        <br>
                                        <span>
                                            <i class="fa-xs fas fa-square"></i> 
                                            Link to filter community list by state
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="detailBox" style="border: none">
                            <div class="wrap-detailBox">
                                <div>
                                    <div class="label-square" style="font-size: 20px;">Relationship Manager</div>
                                    <div class="textDetail" style="font-size: 16px;font-weight: 600;color: #615e5e;">{{this.community ? (this.community.relationship_managers[0] ? this.community.relationship_managers[0].name : 'No RMs Assigned') : 'No RMs Assigned'}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="boxInfo">
                        <div class="wrap-boxInfo">
                            <span style="background-color: #1a4b9e;color: white;padding: 12px 0px;">Pending Change{{this.pendingChanges === 1 ? "" : "s"}}: <span id="pending-changes"
                                                                                           v-html="this.pendingChanges"
                                                                                           @click="navigateToChanges"
                                                                                           style="background: #ffd740"
                                                                                           class="pending-changes cursor-pointer rounded-full px-3 py-1 font-semibold">"</span></span>
                            <p style="color: rgb(60, 59, 59);padding: 12px 0px;text-align: right;font-weight: 700;font-size: 20px;">Last Update</p>
                            <p style="text-align: right;font-weight: 600;">{{ this.latestActivity.user ? this.latestActivity.user.name : null }}</p>
                            <p style="text-align: right" v-html="this.lastUpdated"></p>
                        </div>
                    </div>
                </div>
            </section>
        </loading-card>
        <br><br>
        <div class="flex mb-4">
            <div class="w-full flex items-center">
                <h1 class="flex-no-shrink text-90 font-normal text-2xl">Tasks/Projects</h1>
                <div class="flex-no-shrink ml-auto mb-6">
                    <a href="javascript:void(0)" v-if="!isLoading && projectDetails == null" @click="createProject" class="btn btn-default btn-primary" dusk="create-button">Create Project</a>
                    <a href="javascript:void(0)" v-if="!isLoading && projectDetails && projects.length == 1" @click="storeNewTemplateProject" class="btn btn-default btn-primary" dusk="create-button">Create Onboarding Project</a>
                </div>
            </div>
        </div>
        <div class="relationship-tabs-panel card">
            <div class="loader-io" v-if="isLoading">
                <div class="loadingio-spinner-eclipse-utvtio44ngo">
                    <div class="ldio-aebf04cd3u">
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!isLoading" class="relationship-tabs-panel card">
            <div class="w-full">
                <div v-if="projectDetails">
                    <div class="tabs-wrap border-b-2 border-40 w-full">
                        <div class="tabs flex flex-row overflow-x-auto">
                            <button class="py-5 px-8 border-b-2 focus:outline-none tab" v-for="project in projects" :class="{'text-grey-black font-bold border-primary' : project.data.gid === activeProject, 'text-grey font-semibold border-40' : project.data.gid !== activeProject}" @click="getProjectDetails(project.data.gid)" :id="project.data.gid">
                                {{ project.data.name }} <i class="fa fa-spinner fa-spin" :id="'ps' + project.data.gid"></i>
                            </button>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="add-task-section-wrapper">
                            <div class="section-left">
                                <div class="_btn _btn-default" @click="createNewTask = true">
                                    <svg class="MiniIcon-custom" viewBox="0 0 24 24">
                                        <path d="M10,10V4c0-1.1,0.9-2,2-2s2,0.9,2,2v6h6c1.1,0,2,0.9,2,2s-0.9,2-2,2h-6v6c0,1.1-0.9,2-2,2s-2-0.9-2-2v-6H4c-1.1,0-2-0.9-2-2s0.9-2,2-2H10z"></path>
                                    </svg>
                                    Add Task
                                </div>
                            </div>
                            <div class="section-right _text-right">
                                <div class="_btn _btn-borderless nv-dropdown">
                                    <svg class="MiniIcon-custom" viewBox="0 0 24 24">
                                        <path d="M12,3c5,0,9,4,9,9s-4,9-9,9s-9-4-9-9S7,3,12,3 M12,1C5.9,1,1,5.9,1,12s4.9,11,11,11s11-4.9,11-11S18.1,1,12,1L12,1zM11.2,16.2l6-6c0.4-0.4,0.4-1,0-1.4s-1-0.4-1.4,0l-5.3,5.3l-2.3-2.3c-0.4-0.4-1-0.4-1.4,0s-0.4,1,0,1.4l3,3c0.2,0.2,0.5,0.3,0.7,0.3S11,16.4,11.2,16.2z">
                                        </path>
                                    </svg>
                                    <span v-if="taskFilter.complete == '' || taskFilter.complete == 'all'">All Tasks</span>
                                    <span v-if="taskFilter.complete == 'true'">Complete Tasks</span>
                                    <span v-if="taskFilter.complete == 'false'">Incomplete Tasks</span>
                                    <div class="task-head-box-dropdown nv-dropdown-menu">
                                        <div class="each-box" @click="filterTasks('completed', 'all')">
                                            <a href="javascript:void(0)">All Task</a>
                                        </div>
                                        <div class="each-box">
                                            <a href="javascript:void(0)" @click="filterTasks('completed', 'false')">Incomplete tasks</a>
                                        </div>
                                        <div class="each-box">
                                            <a href="javascript:void(0)" @click="filterTasks('completed', 'true')">Complete Tasks</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="_assigned-box">
                                    <select class="_custom-select" v-model="taskFilter.assignee" @change="filterTasks">
                                        <option value="">Assignee</option>
                                        <option v-if="users.length > 0" v-for="user in users" :value="user.gid">{{ user.name }}</option>
                                    </select>
                                </div>
                                <div class="_assigned-box">
                                    <select class="_custom-select" v-model="taskFilter.section" @change="filterTasks">
                                        <option value="">Choose type</option>
                                        <option v-if="sections.length > 0" v-for="section in sections" :value="section.gid">{{ section.name }}</option>
                                    </select>
                                </div>
                                <div class="_assigned-box">
                                    <select class="_custom-select" v-model="taskFilter.due_on" @change="filterTasks">
                                        <option value="">Choose Due Date</option>
                                        <option value="7">Due in 7 days</option>
                                        <option value="30">Up in 30 days</option>
                                        <option value="90">Up in 90 days</option>
                                    </select>
                                </div>
                                <div class="_assigned-box">
                                    <input type="text" class="_custom-input-search" placeholder="Search" v-model="taskFilter.name" @change="keyTyping" @keyup="keyTyping">
                                    <div class="search-logo">
                                        <svg class="" focusable="false" viewBox="0 0 32 32" style="width: 14px;">
                                            <path d="M29.707,28.293l-8.256-8.256C23.042,18.13,24,15.677,24,13c0-6.075-4.925-11-11-11S2,6.925,2,13s4.925,11,11,11c2.677,0,5.13-0.958,7.037-2.549l8.256,8.256L29.707,28.293z M4,13c0-4.963,4.037-9,9-9c4.963,0,9,4.037,9,9s-4.037,9-9,9C8.037,22,4,17.963,4,13z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-wrapper">
                            <div class="task-list-wrapper" :class="{'task-list-half': sideBar == 1 ? true:false}">
                                <div class="task-list-header">
                                    <div class="task-name-box">
                                        Task name
                                    </div>
                                    <div class="task-assignee-box">
                                        Assignee
                                    </div>
                                    <div class="task-assignee-box border-right-none cursor-pointer" @click="sortTask">
                                        Due Date
                                        <!--<div class="logo-1 nv-dropdown">
                                            <svg class="svg-logo" focusable="false" viewBox="0 0 32 32">
                                                <path d="M25.9,12.9c-0.5-0.6-1.5-0.7-2.1-0.2L16,19.1l-7.8-6.4c-0.6-0.5-1.6-0.4-2.1,0.2c-0.5,0.6-0.4,1.6,0.2,2.1l8.8,7.2  c0.2,0.2,0.6,0.3,0.9,0.3s0.7-0.1,0.9-0.3l8.8-7.2C26.3,14.5,26.4,13.5,25.9,12.9z"></path>
                                            </svg>
                                            <div class="task-head-box-dropdown nv-dropdown-menu">
                                                <div class="each-box">
                                                    <a href="javascript:void(0)">Sort by</a>
                                                    <a href="javascript:void(0)">Remove sort</a>
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="logo-2" v-if="isSort">
                                            <svg class="mini-icon" viewBox="0 0 24 24">
                                                <path d="M4.7,14.1l7.6,7.6c0.4,0.4,1,0.4,1.4,0l7.6-7.6c0.4-0.4,0.4-1,0-1.4s-1-0.4-1.4,0L14,18.6V3c0-0.6-0.4-1-1-1c-0.6,0-1,0.4-1,1v15.6l-5.9-5.9c-0.2-0.2-0.5-0.3-0.7-0.3s-0.5,0.1-0.7,0.3C4.3,13.1,4.3,13.8,4.7,14.1z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="task-list-body" v-if="createNewTask">
                                    <div class="task-name-box cursor-pointer">
                                        <div @click="" class="border-radious-icon" :class="{'task-complete': isTaskComplete == 1 ? true : false}">
                                            <svg class="MiniIcon"
                                                 viewBox="0 0 24 24">
                                                <path d="M9.5,18.2c-0.4,0.4-1,0.4-1.4,0l-3.8-3.8C4,14,4,13.4,4.3,13s1-0.4,1.4,0l3.1,3.1l8.6-8.6c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 L9.5,18.2z"></path>
                                            </svg>
                                        </div>
                                        <span><input type="text" v-model="task.name" id="createTaskOnSubmit" class="task-body-custom-input"></span>
                                        <div @click="storeTask" class="detail-option">Create
                                            <svg class="MiniIcon-right" viewBox="0 0 24 24">
                                                <path d="M8.9,20.4c-0.4,0-0.7-0.1-1-0.4c-0.6-0.6-0.7-1.5-0.1-2.1l5.2-5.8L7.8,6C7.3,5.4,7.3,4.4,8,3.9C8.6,3.3,9.5,3.4,10.1,4l6.1,7.1c0.5,0.6,0.5,1.4,0,2l-6.1,6.8C9.8,20.3,9.4,20.4,8.9,20.4z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="task-assignee-box cursor-pointer nv-dropdown">
                                        <div class="nv-dropdown-trigger">
                                            <div class="assignee-box-logo">
                                                <svg class="inside-logo" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                </svg>
                                            </div>
                                            <span><input type="text" class="assignee-box-input assigned-input" @keyup="textSearch($event, false)" @blur="clearInput($event, false)"></span>
                                        </div>

                                        <div class="assignee-box-dropdown nv-dropdown-menu">
                                            <div class="each-assignee" v-if="users.length > 0" v-for="user in users" @click="collapseDropdown(user.gid)">
                                                <div class="profile-img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                <div class="name-text">{{ user.name }}</div>
                                            </div>
                                        </div>

                                        <div class="assigned-person" v-if="task.assignee">
                                            <div class="img-box"  style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                            <div class="text-1">{{ users[users.findIndex((element) => element.gid == task.assignee)].name }}</div>
                                        </div>
                                    </div>
                                    <div class="task-assignee-box cursor-pointer border-right-none">
                                        <div class="assignee-box-logo">
                                            <svg class="inside-logo" focusable="false" viewBox="0 0 32 32">
                                                <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                            </svg>
                                        </div>
                                        <span>
                                            <flat-pickr
                                                v-model="task.due_on"
                                                :config="{altInput: true, altFormat: 'F j, Y'}"
                                                @on-change="task.due_on = convert($event)"
                                                class="assignee-box-input assigned-input"
                                                name="date">
                                            </flat-pickr>
                                        </span>
                                    </div>
                                </div>
                                <div class="task-list-body" v-if="isSort" v-for="task in tasks">
                                    <div class="task-name-box cursor-pointer">
                                        <div class="border-radious-icon" :class="{'task-complete': task[0].completed ? true : false}" @click="toogleComplete('taskDetailsCompleteness' + task[0].gid)">
                                            <svg class="MiniIcon" viewBox="0 0 24 24">
                                                <path d="M9.5,18.2c-0.4,0.4-1,0.4-1.4,0l-3.8-3.8C4,14,4,13.4,4.3,13s1-0.4,1.4,0l3.1,3.1l8.6-8.6c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 L9.5,18.2z"></path>
                                            </svg>
                                        </div>
                                        <input type="checkbox" v-if="task[0].completed" @click="editTask(task[0].gid, 'completed', $event, index, i)" :id="'taskDetailsCompleteness' + task[0].gid" style="display:none;" checked>
                                        <input type="checkbox" v-else="" @click="editTask(task[0].gid, 'completed', $event, index, i)" :id="'taskDetailsCompleteness' + task[0].gid" style="display:none;">
                                        <span><input type="text" class="task-body-custom-input" placeholder="Write a task name" :value="task[0].name" @change="editTask(task[0].gid, 'name', $event, index, i)"></span>
                                        <span class="comment-section-name" v-if="task[0].num_likes">
                                            <span class="comment-count-like">{{ task[0].num_likes }}</span>
                                            <svg class="comment-logo-like cursor-pointer" viewBox="0 0 24 24"><path
                                                d="M2.7,8H5v2v10v2H2.7C1.2,22,0,20.8,0,19.4v-8.7C0,9.2,1.2,8,2.7,8z M23.1,9.2C22.4,8.4,21.5,8,20.5,8H16V5.2 C16,3.5,16.5,2,15.2,1c-0.6-0.5-1.5-0.6-2.2-0.5c-0.8,0.2-1.4,0.7-1.8,1.5L7,8v14h12.2c1.7,0,3.2-1.2,3.4-2.9l1.2-7 C24.1,11,23.8,10,23.1,9.2z"></path></svg>
                                        </span>
                                        <span @click="showTask(task[0].gid)" class="comment-section-name" v-if="task['comments'] > 0"><span class="comment-count">{{ task['comments'] }}</span>
                                            <svg class="comment-logo cursor-pointer" focusable="false" viewBox="0 0 32 32" height="14px" width="14px">
                                        <path d="M5,31c-0.1,0-0.3,0-0.4-0.1C4.2,30.7,4,30.4,4,30v-7.1c-2.5-2.3-4-5.5-4-8.9C0,7.4,5.4,2,12,2h8c6.6,0,12,5.4,12,12 s-5.4,12-12,12h-8c-0.1,0-0.3,0-0.4,0l-5.9,4.8C5.4,30.9,5.2,31,5,31z M12,4C6.5,4,2,8.5,2,14c0,3,1.3,5.8,3.6,7.7C5.9,21.9,6,22.2,6,22.5v5.4l4.6-3.7C10.8,24,11,24,11.3,24h0.1c0.2,0,0.4,0,0.6,0h8c5.5,0,10-4.5,10-10S25.5,4,20,4 C20,4,12,4,12,4z"></path>
                                    </svg>
                                        </span>
                                        <span @click="showTask(task[0].gid)" class="comment-section-name" v-if="task['subTasks'] > 0"><span class="comment-count">{{ task['subTasks'] }}</span>
                                            <svg class="comment-logo cursor-pointer" focusable="false" viewBox="0 0 32 32" height="14px" width="14px">
                                                <path d="M25,20c-2.4,0-4.4,1.7-4.9,4H11c-3.9,0-7-3.1-7-7v-5h16.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5s-2.2-5-5-5c-2.4,0-4.4,1.7-4.9,4H4V3c0-0.6-0.4-1-1-1S2,2.4,2,3v14c0,5,4,9,9,9h9.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5S27.8,20,25,20z M25,8c1.7,0,3,1.3,3,3s-1.3,3-3,3s-3-1.3-3-3S23.3,8,25,8z M25,28c-1.7,0-3-1.3-3-3s1.3-3,3-3s3,1.3,3,3S26.7,28,25,28z"></path>
                                            </svg>
                                        </span>
                                        <div v-if="sideBar == 0" @click="showTask(task[0].gid)" class="detail-option">Detail
                                            <svg class="MiniIcon-right" viewBox="0 0 24 24">
                                                <path d="M8.9,20.4c-0.4,0-0.7-0.1-1-0.4c-0.6-0.6-0.7-1.5-0.1-2.1l5.2-5.8L7.8,6C7.3,5.4,7.3,4.4,8,3.9C8.6,3.3,9.5,3.4,10.1,4l6.1,7.1c0.5,0.6,0.5,1.4,0,2l-6.1,6.8C9.8,20.3,9.4,20.4,8.9,20.4z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="task-assignee-box cursor-pointer nv-dropdown">
                                        <div class="nv-dropdown-trigger">
                                            <div id="'assignee-logo-id' + task[0].gid" class="assignee-box-logo" v-if="task[0].assignee == null">
                                                <svg class="inside-logo" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                </svg>
                                            </div>
                                            <span><input type="text" class="assignee-box-input nv-dropdown-trigger" @keyup="textSearch($event, false)" @blur="clearInput($event, false)"></span>

                                            <div class="assigned-person" v-if="task[0].assignee">
                                                <div class="img-box"  style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                <div class="text-1">{{ task[0].assignee.name }}</div>
                                            </div>
                                        </div>
                                        <div class="assignee-box-dropdown nv-dropdown-menu">
                                            <div class="each-assignee" v-if="users.length > 0" v-for="user in users" @click="editTask(task[0].gid, 'assignee', user, index, i)">
                                                <div class="profile-img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                <div class="name-text">{{ user.name }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="task-assignee-box cursor-pointer border-right-none" :title="duedate(task[0].due_on)">
                                        <div class="assignee-box-logo">
                                            <svg class="inside-logo" focusable="false" viewBox="0 0 32 32">
                                                <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                            </svg>
                                        </div>
                                        <span>
                                            <flat-pickr
                                                :value="task[0].due_on"
                                                :config="{altInput: true, altFormat: 'F j, Y'}"
                                                @on-change="editTask(task[0].gid, 'due_on', $event, index, i)"
                                                class="assignee-box-input assigned-input"
                                                name="date">
                                            </flat-pickr>
                                        </span>
                                    </div>
                                </div>
                                <div class="" v-if="sectionData.length > 0" v-for="(section, index) in sectionData" :data-v="index" :key="index" @click="getLikeDataById(section[0].gid)">
                                    <div class="section-header">
                                        <div class="d-flex-inline cursor-pointer" :id="'nvTl' + section[0].gid">{{ section[0].name }}
                                            <svg style="enable-background:new 0 0 511.626 511.626;width: 23px;height: 23px;"
                                                 class="MiniIcon-right"
                                                 focusable="false" viewBox="0 0 32 32">
                                                <path d="M25.9,12.9c-0.5-0.6-1.5-0.7-2.1-0.2L16,19.1l-7.8-6.4c-0.6-0.5-1.6-0.4-2.1,0.2c-0.5,0.6-0.4,1.6,0.2,2.1l8.8,7.2  c0.2,0.2,0.6,0.3,0.9,0.3s0.7-0.1,0.9-0.3l8.8-7.2C26.3,14.5,26.4,13.5,25.9,12.9z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p style="color:red;font-size:12;display:none;" class="noDatFnd" v-if="section['tasks'].length < 1" :id="'noData' + section[0].gid">No Task Found</p>
                                    <div :id="'nvCl' + section[0].gid" :style="[section.open === true ? {'display': 'block'} : {'display': 'none'}]">
                                        <div class="fa-3x">
                                            <i class="fa fa-spinner fa-spin" :id="'spinner' + section[0].gid" style="display:none"></i>
                                        </div>
                                        <div class="task-list-body-section" v-if="section['tasks'].length > 0" v-for="(task, i) in section['tasks']" :key="i">
                                            <div class="task-name-box cursor-pointer">
                                                <div class="border-radious-icon" :class="{'task-complete': task[0].data.completed ? true : false}" @click="toogleComplete('taskDetailsCompleteness' + task[0].data.gid)">
                                                    <svg class="MiniIcon" viewBox="0 0 24 24">
                                                        <path d="M9.5,18.2c-0.4,0.4-1,0.4-1.4,0l-3.8-3.8C4,14,4,13.4,4.3,13s1-0.4,1.4,0l3.1,3.1l8.6-8.6c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 L9.5,18.2z"></path>
                                                    </svg>
                                                </div>
                                                <input type="checkbox" v-if="task[0].data.completed" @click="editTask(task[0].data.gid, 'completed', $event, index, i)" :id="'taskDetailsCompleteness' + task[0].data.gid" style="display:none;" checked>
                                                <input type="checkbox" v-else="" @click="editTask(task[0].data.gid, 'completed', $event, index, i)" :id="'taskDetailsCompleteness' + task[0].data.gid" style="display:none;">
                                                <span><input type="text" class="task-body-custom-input" placeholder="Write a task name" :value="task[0].data.name" @change="editTask(task[0].data.gid, 'name', $event, index, i)"></span>
                                                <span class="comment-section-name" v-if="task[0].data.num_likes">
                                                    <span class="comment-count-like">{{ task[0].data.num_likes }}</span>
                                                    <svg class="comment-logo-like cursor-pointer" viewBox="0 0 24 24"><path
                                                        d="M2.7,8H5v2v10v2H2.7C1.2,22,0,20.8,0,19.4v-8.7C0,9.2,1.2,8,2.7,8z M23.1,9.2C22.4,8.4,21.5,8,20.5,8H16V5.2 C16,3.5,16.5,2,15.2,1c-0.6-0.5-1.5-0.6-2.2-0.5c-0.8,0.2-1.4,0.7-1.8,1.5L7,8v14h12.2c1.7,0,3.2-1.2,3.4-2.9l1.2-7 C24.1,11,23.8,10,23.1,9.2z"></path></svg>
                                                </span>
                                                <span @click="showTask(task[0].data.gid)" class="comment-section-name" v-if="task['comments'] > 0"><span class="comment-count">{{ task['comments'] }}</span>
                                                    <svg class="comment-logo cursor-pointer" focusable="false" viewBox="0 0 32 32" height="14px" width="14px">
                                                        <path d="M5,31c-0.1,0-0.3,0-0.4-0.1C4.2,30.7,4,30.4,4,30v-7.1c-2.5-2.3-4-5.5-4-8.9C0,7.4,5.4,2,12,2h8c6.6,0,12,5.4,12,12 s-5.4,12-12,12h-8c-0.1,0-0.3,0-0.4,0l-5.9,4.8C5.4,30.9,5.2,31,5,31z M12,4C6.5,4,2,8.5,2,14c0,3,1.3,5.8,3.6,7.7C5.9,21.9,6,22.2,6,22.5v5.4l4.6-3.7C10.8,24,11,24,11.3,24h0.1c0.2,0,0.4,0,0.6,0h8c5.5,0,10-4.5,10-10S25.5,4,20,4 C20,4,12,4,12,4z"></path>
                                                    </svg>
                                                </span>
                                                <span @click="showTask(task[0].data.gid)" class="comment-section-name" v-if="task['subTasks'] > 0"><span class="comment-count">{{ task['subTasks'] }}</span>
                                                    <svg class="comment-logo cursor-pointer" focusable="false" viewBox="0 0 32 32" height="14px" width="14px">
                                                        <path d="M25,20c-2.4,0-4.4,1.7-4.9,4H11c-3.9,0-7-3.1-7-7v-5h16.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5s-2.2-5-5-5c-2.4,0-4.4,1.7-4.9,4H4V3c0-0.6-0.4-1-1-1S2,2.4,2,3v14c0,5,4,9,9,9h9.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5S27.8,20,25,20z M25,8c1.7,0,3,1.3,3,3s-1.3,3-3,3s-3-1.3-3-3S23.3,8,25,8z M25,28c-1.7,0-3-1.3-3-3s1.3-3,3-3s3,1.3,3,3S26.7,28,25,28z"></path>
                                                    </svg>
                                                </span>
                                                <div v-if="sideBar == 0" @click="showTask(task[0].data.gid)" class="detail-option">Detail
                                                    <svg class="MiniIcon-right" viewBox="0 0 24 24">
                                                        <path d="M8.9,20.4c-0.4,0-0.7-0.1-1-0.4c-0.6-0.6-0.7-1.5-0.1-2.1l5.2-5.8L7.8,6C7.3,5.4,7.3,4.4,8,3.9C8.6,3.3,9.5,3.4,10.1,4l6.1,7.1c0.5,0.6,0.5,1.4,0,2l-6.1,6.8C9.8,20.3,9.4,20.4,8.9,20.4z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="task-assignee-box cursor-pointer nv-dropdown">
                                                <div class="nv-dropdown-trigger">
                                                    <div id="'assignee-logo-id' + task[0].data.gid" class="assignee-box-logo" v-if="task[0].data.assignee == null">
                                                        <svg class="inside-logo" focusable="false" viewBox="0 0 32 32">
                                                            <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                        </svg>
                                                    </div>
                                                    <span><input type="text" class="assignee-box-input nv-dropdown-trigger" @keyup="textSearch($event, false)" @blur="clearInput($event, false)"></span>

                                                    <div class="assigned-person" v-if="task[0].data.assignee">
                                                        <div class="img-box"  style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                        <div class="text-1">{{ task[0].data.assignee.name }}</div>
                                                    </div>
                                                </div>
                                                <div class="assignee-box-dropdown nv-dropdown-menu">
                                                    <div class="each-assignee" v-if="users.length > 0" v-for="user in users" @click="editTask(task[0].data.gid, 'assignee', user, index, i)">
                                                        <div class="profile-img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                        <div class="name-text">{{ user.name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="task-assignee-box cursor-pointer border-right-none" :title="duedate(task[0].data.due_on)">
                                                <div class="assignee-box-logo">
                                                    <svg class="inside-logo" focusable="false" viewBox="0 0 32 32">
                                                        <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                    </svg>
                                                </div>
                                                <span>
                                                    <flat-pickr
                                                        :value="task[0].data.due_on"
                                                        :config="{altInput: true, altFormat: 'F j, Y'}"
                                                        @on-change="editTask(task[0].data.gid, 'due_on', $event, index, i)"
                                                        class="assignee-box-input assigned-input"
                                                        name="date">
                                                    </flat-pickr>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="task-list-detail-wrapper" id="task-detail" :class="{'hideMe': sideBar == 0 ? true:false}">
                                <div class="loader-io" style="display: none">
                                    <div class="loadingio-spinner-eclipse-utvtio44ngo">
                                        <div class="ldio-aebf04cd3u">
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
                                                <input type="checkbox" v-if="taskDetails[0].data.completed" @click="inlineTaskUpdate(taskDetails[0].data.gid, 'completed', $event)" id="taskDetailsCompleteness" style="display:none;" checked>
                                                <input type="checkbox" v-else="" @click="inlineTaskUpdate(taskDetails[0].data.gid, 'completed', $event)" id="taskDetailsCompleteness" style="display:none;">
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
                                                <a title="Delete" @click="deleteTask(taskDetails[0].data.gid)"
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
                                        <input type="text" class="input-big" placeholder="Write a task name" :value="taskDetails[0].data.name" @change="inlineTaskUpdate(taskDetails[0].data.gid, 'name', $event)">
                                    </div>
                                    <div class="head-text-section border-bottom-task-list">
                                        <div class="radious-square-input cursor-pointer nv-dropdown">
                                            <div class="logo-border">
                                                <svg class="input-icon-1" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                </svg>
                                            </div>

                                            <input type="text" placeholder="Assignee" class="input-design" @keyup="textSearch($event, false)" @blur="clearInput($event, false)">

                                            <div class="assigned-person" v-if="taskDetails[0].data.assignee">
                                                <div class="img-box" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                <div class="text-1">{{ taskDetails[0].data.assignee.name }}</div>
                                            </div>

                                            <div class="assignee-box-dropdown nv-dropdown-menu">
                                                <div class="each-assignee" v-if="users.length > 0" v-for="user in users" @click="inlineTaskUpdate(taskDetails[0].data.gid, 'assignee', user)">
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
                                                @on-change="inlineTaskUpdate(taskDetails[0].data.gid, 'due_on', $event)"
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
                                        <textarea name="" class="custom-text-area" cols="30" rows="5" placeholder="Description" :value="taskDetails[0].data.notes" @change="inlineTaskUpdate(taskDetails[0].data.gid, 'notes', $event)"></textarea>
                                    </div>
                                    <div class="head-text-section _position-relative border-bottom-task-list">
                                        <div class="_input-logo">
                                            <svg class="t-logo" focusable="false" viewBox="0 0 32 32">
                                                <path d="M10,13.5c0.8,0,1.5,0.7,1.5,1.5s-0.7,1.5-1.5,1.5S8.5,15.8,8.5,15S9.2,13.5,10,13.5z M23,14h-8c-0.6,0-1,0.4-1,1s0.4,1,1,1h8c0.6,0,1-0.4,1-1S23.6,14,23,14z M23,20h-8c-0.6,0-1,0.4-1,1s0.4,1,1,1h8c0.6,0,1-0.4,1-1S23.6,20,23,20z M10,19.5c0.8,0,1.5,0.7,1.5,1.5s-0.7,1.5-1.5,1.5S8.5,21.8,8.5,21S9.2,19.5,10,19.5z M24,2h-2.2c-0.4-1.2-1.5-2-2.8-2h-6c-1.3,0-2.4,0.8-2.8,2H8C4.7,2,2,4.7,2,8v18c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M13,2h6c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1h-6c-0.6,0-1-0.4-1-1V3C12,2.4,12.4,2,13,2z M28,26c0,2.2-1.8,4-4,4H8c-2.2,0-4-1.8-4-4V8c0-2.2,1.8-4,4-4h2v1c0,1.7,1.3,3,3,3h6c1.7,0,3-1.3,3-3V4h2c2.2,0,4,1.8,4,4V26z"></path>
                                            </svg>
                                        </div>
                                        <div class="project-name-label">{{ projectDetails.data.name }}</div>
                                        <div class="project-select-box">
                                            <select @change="inlineTaskUpdate(taskDetails[0].data.gid, 'section', $event)" class="cursor-pointer">
                                                <option v-for="section in sections" :value="section.gid" v-if="taskDetails[0].data.memberships.length > 0 && taskDetails[0].data.memberships[0].section.gid == section.gid" selected>{{ section.name }}</option>
                                                <option :value="section.gid" v-else="">{{ section.name }}</option>
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
                                                <div class="logo-1" @click="createSubTask(taskDetails[0].data.gid)">
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
                                        <div class="new-task" v-if="taskDetails.subTasks.length > 0" v-for="(t, index) in taskDetails.subTasks" :key="index">
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
                                                    <span class="comment-count" v-if="t['comments']">{{ t['comments'] }}</span>
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
                </div>
                <div v-if="projectDetails == null" class="card">
                    <h2 class="ph">No projects yet</h2>
                </div>
            </div>
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
                isTaskComplete: 0,
                isSort: false
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
            getProjects() {
                let _this = this;
                this.isLoading = true;
                this.project.name = null;
                Nova.request().get('/api/asana/project?osusr_mlv_community_id=' + this.resourceId).then(response => {
                    this.isLoading = false;

                    if (response.data.data) {
                        if(response.data.data.genToken === true){
                            $('#authAsana').css('visibility', 'visible');
                        }
                        this.projectDetails = response.data.data.project[0];
                        this.projects = response.data.data.projects;
                        this.activeProject = this.projectDetails.data.gid;
                        this.taskFilter.project = this.projectDetails.data.gid;
                        this.sections = response.data.data.project['sections'].data;
                        this.sectionData = response.data.data.project['sectionData'];
                        this.users = response.data.data.project['users'].data;
                        this.task.projects = [this.projectDetails.data.gid];
                        this.subTask.project = this.projectDetails.data.gid;
                        this.task.workspace = this.projectDetails.data.workspace.gid;
                        
                        if(localStorage.getItem('projects') !== null){
                            const storedItems = JSON.parse(localStorage.getItem('projects'));
                            if(Object.keys(storedItems).length > 0){
                                var isProjectExists = false;
                                Object.keys(storedItems).map(projKey => {
                                    if(projKey === response.data.data.projects[0].data.gid){
                                        const curProj = storedItems[projKey];
                                        this.projectDetails = curProj[0];
                                        this.activeProject = this.projectDetails.data.gid;
                                        this.taskFilter.project = this.projectDetails.data.gid;
                                        this.sections = curProj['sections'].data;
                                        this.sectionData = curProj['sectionData'];
                                        this.users = curProj['users'].data;
                                        this.task.projects = [this.projectDetails.data.gid];
                                        this.subTask.project = this.projectDetails.data.gid;
                                        this.task.workspace = this.projectDetails.data.workspace.gid;
                                        isProjectExists = true;
                                        return true;
                                    }
                                });
                                $('#' + response.data.data.projects[0].data.gid).click();
                            }
                        }

                        response.data.data.projects.map(proj => {
                            $('#ps'+proj.data.gid).show();
                            this.asyncProjLoad(proj.data.gid, response.data.data.projects[0].data.gid)
                        })
                    } else {
                        this.projectDetails = null;
                        this.projects = [];
                    }

                    setTimeout(function () {
                        _this.uiUpdateMounted()
                    }, 500);
                });
            },
            asyncProjLoad(id, firstId){
                Nova.request().get('/api/asana/project/show/' + id).then(response => {
                    this.isLoading = false;
                    if (response.data.data) {
                        const projectDetails = response.data.data[0];
                        //Store Localstorage
                        const activeProjectKey = projectDetails.data.gid;
                        const activeProjectData = response.data.data;

                        const resObjectObject = localStorage.getItem('projects') === null  ? {} : JSON.parse(localStorage.getItem('projects'));
                        resObjectObject[activeProjectKey] = this.mergeRecursive(activeProjectData, resObjectObject[activeProjectKey]);
                        const resObjectString = JSON.stringify(resObjectObject);
                        localStorage.setItem('projects', resObjectString)
                        
                        if(Object.keys(resObjectObject).length > 0){
                            if(firstId == id){
                                $('#' + firstId).click();
                            }
                        }
                        
                        $('#ps'+id).hide();
                    }
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
                this.isLoading = true;
                this.project.name = this.community.STATE + '-' + this.community.COUNTY + '-' + this.community.FRIENDLYNAME + '-' + this.community.COMMUNITYID + '-Standard';

                window.location.href = window.location.origin+"/accessToken/"+JSON.stringify(this.project);
                return false;
                
                Nova.request().post('/api/asana/project/store', this.project).then(response => {
                    this.isLoading = false;

                    if (response.data.status === 200) {
                        this.getProjects();
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            getProjectDetails(id) {
                $('.noDatFnd').hide();
                let _this = this;

                const storedItems = JSON.parse(localStorage.getItem('projects'));
                var isProjectExists = false;
                Object.keys(storedItems).map(projKey => {
                    if(projKey === id){
                        const curProj = storedItems[projKey];
                        this.projectDetails = curProj[0];
                        this.activeProject = this.projectDetails.data.gid;
                        this.taskFilter.project = this.projectDetails.data.gid;
                        this.sections = curProj['sections'].data;
                        this.sectionData = curProj['sectionData'];
                        this.users = curProj['users'].data;
                        this.task.projects = [this.projectDetails.data.gid];
                        this.subTask.project = this.projectDetails.data.gid;
                        this.task.workspace = this.projectDetails.data.workspace.gid;
                        isProjectExists = true;
                        return true;
                    }
                });
                if(isProjectExists){
                    return false;
                }

                Nova.request().get('/api/asana/project/show/' + id).then(response => {
                    if (response.data.data) {
                        this.projectDetails = response.data.data[0];
                        this.activeProject = this.projectDetails.data.gid;
                        this.taskFilter.project = this.projectDetails.data.gid;
                        this.sections = response.data.data['sections'].data;
                        this.sectionData = response.data.data['sectionData'];
                        this.users = response.data.data['users'].data;
                        this.task.projects = [this.projectDetails.data.gid];
                        this.subTask.project = this.projectDetails.data.gid;
                        this.task.workspace = this.projectDetails.data.workspace.gid;

                        //Store Localstorage
                        const activeProjectKey = this.projectDetails.data.gid;
                        const activeProjectData = response.data.data;

                        const resObjectObject = JSON.parse(localStorage.getItem('projects'));
                        resObjectObject[activeProjectKey] = activeProjectData;
                        const resObjectString = JSON.stringify(resObjectObject);
                        localStorage.setItem('projects', resObjectString)

                        $('#ps'+id).hide();
                    } else {

                    }

                    setTimeout(function () {
                        _this.uiUpdateMounted()
                    }, 500);
                });
            },
            getLikeDataById(id){
                $('#spinner' + id).hide();
                $('#noData' + id).hide();
                var project = false;
                console.log('Clicked Outer');
                if($('#nvCl' + id).is(":visible")){
                    console.log('visible', id);
                    $('#nvCl' + id).hide();
                }else{
                    console.log('not visible', id);
                    $('#nvCl' + id).show();
                }

                const secDat = this.sectionData.map(section => {
                    if(section[0].gid == id){
                        console.log('Initial Open..........', section.open)
                        if (typeof section.open == "undefined") {
                            section.open = true;
                        }else{
                            section.open = !section.open
                        }
                        console.log('Section Stat After', section.open)
                        const resObjectTabStatus = JSON.parse(localStorage.getItem('projects'));
                        resObjectTabStatus[this.activeProject].sectionData.map(sectionTabData => {
                            // console.log('4', sectionTabData);
                            if(sectionTabData[0].gid == id){
                                sectionTabData.open = section.open;
                            }
                        });
                        const resObjectStringTabData = JSON.stringify(resObjectTabStatus);
                        localStorage.setItem('projects', resObjectStringTabData)
                    }
                    if(section[0].gid == id && section.tasks.length > 0){
                        project = true;
                        return;
                    }
                });
                if(project) return false;
                
                var hasSectionId = false;
                const resObjectObject = JSON.parse(localStorage.getItem('projects'));
                resObjectObject[this.activeProject].sectionData.map(section => {
                    if(section[0].gid == id){
                        console.log('Section',section)
                        this.sectionData.map((stateSection, key) => {
                            if(stateSection[0].gid == id  && stateSection.tasks.length > 0){

                                console.log('stateSection', stateSection);
                                stateSection = section;
                                hasSectionId = true;
                            }
                        })
                    }
                })
                if(hasSectionId) return false;
                

                $('#spinner'+id).show();
                Nova.request().get('/api/asana/project/showlike/' + id).then(response => {
                    $('#spinner' + id).hide();
                    $('#noData' + id).show();
                    this.sectionData.map((section, key) => {
                        if(section[0].gid == response.data.section_id){
                            section.tasks = response.data.data[0].tasks;
                            const resObjectObject = JSON.parse(localStorage.getItem('projects'));
                            resObjectObject[this.activeProject].sectionData[key].tasks = response.data.data[0].tasks;
                            const resObjectString = JSON.stringify(resObjectObject);
                            localStorage.setItem('projects', resObjectString)
                        }
                    })
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
                        this.getProjects();
                    } else {
                        this.errors = response.data.errors;
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
            inlineTaskUpdate(id, name, e) {
                $('.task-details-wrapper').hide();
                $('.loader-io').css('display', 'flex');

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
                } else if (name == 'due_on') {
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
                            this.getProjects();
                        }  else if (name == 'assignee') {
                            this.taskDetails[0].data.assignee = e;
                        }
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            deleteTask(id) {
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

                        Nova.request().post('/api/asana/task/destroy/' + id, {_method: 'DELETE'}).then(response => {
                            this.isLoading = false;

                            if (response.data.status === 200) {
                                THIS.getProjects();
                            } else {
                                THIS.errors = response.data.errors;
                            }
                        });
                    }
                });
            },
            filterTasks(key, val) {
                let THIS = this;
                this.isLoading = true;

                if (key == 'completed') {
                    this.taskFilter.complete = val;
                } else {
                    if (val) {
                        this.taskFilter.due_on = val;
                    }
                }

                let params = new URLSearchParams(THIS.taskFilter);
                params = params.toString();

                Nova.request().get('/api/asana/task/show?' + params).then(response => {
                    this.isLoading = false;

                    setTimeout(function () {
                        THIS.uiUpdateMounted()
                    }, 500);

                    if (response.data.status === 200) {
                        THIS.sectionData = response.data.data;
                    } else {
                        THIS.errors = response.data.errors;
                    }
                });
            },
            keyTyping: function(){
                let THIS = this;
                clearInterval(THIS.keywordTyping);
                this.keywordTyping = setInterval(function () {
                    clearInterval(THIS.keywordTyping);
                    THIS.filterTasks();
                }, 1000)
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
            createSubTask(id) {
                $('.task-details-wrapper').hide();
                $('.loader-io').css('display', 'flex');

                Nova.request().post('/api/asana/task/' + id + '/subtasks', this.subTask).then(response => {
                    $('.loader-io').hide();
                    $('.task-details-wrapper').show();

                    if (response.data.status === 200) {
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
                        this.taskDetails.comments = response.data.data;
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
            sortTask() {
                let _this = this;
                this.isSort = !this.isSort;
                let formData = {
                    project: this.projectDetails.data.gid,
                    due_on: 'due_on'
                };
                let params = new URLSearchParams(formData);
                params = params.toString();

                if (this.isSort) {
                    this.isLoading = true;

                    Nova.request().get('/api/asana/task/sort?' + params).then(response => {
                        this.isLoading = false;

                        if (response.status == 200) {
                            this.tasks = response.data.data.tasks;
                            this.sectionData = response.data.data.sections;

                            setTimeout(function () {
                                _this.uiUpdateMounted()
                            }, 500);
                        } else {
                            this.errors = response.data.msg.errors;
                        }
                    });
                } else {
                    this.getProjects();
                }
            },
            storeNewTemplateProject() {
                this.isLoading = true;
                let formData = new FormData();
                formData.append('name', this.community.STATE + '-' + this.community.COUNTY + '-' + this.community.FRIENDLYNAME + '-' + this.community.COMMUNITYID + '-Onboarding');
                formData.append('osusr_mlv_community_id', this.community.COMMUNITYID);

                Nova.request().post('/api/asana/project/duplicate', formData).then(response => {
                    this.isLoading = false;

                    if (response.data.status === 200) {
                        this.getProjects();
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

            $("#createTaskOnSubmit").keydown(function (e) {
                alert('Not')
                if (e.keyCode == 13) {
                    console.log("put function call here");
                    submitchat();
                    e.preventDefault();
                }
            });
            function submitchat(){
                alert('Entered')
            }
            $("#createTaskOnSubmit").click(function () {
                alert('Not')
            });
        },
        mounted() {
            this.getProjects();

        }
    }
    $("#createTaskOnSubmit").click(function () {
        alert('Not')
    });
    $("#createTaskOnSubmit").keydown(function (e) {
        alert('Not')
        if (e.keyCode == 13) {
            console.log("put function call here");
            submitchat();
            e.preventDefault();
        }
    });
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
        font-size:16px;
        transition: all .5s;
    }
    .hoverUnderLine:hover{
        text-decoration: underline;
        color: #0a4c9e;
        cursor: pointer;
    }
    .cmOpenInfo{
        position: relative;
        color: #616f7f;
        padding: 5px 20px 5px;
    }
    .cmOpenInfo > span{
        font-size:14px;
        transition: all .5s;
    }
    .cmOpenInfo > span:hover{
        text-decoration: underline;
        color: #0a4c9e;
        cursor: pointer;
    }
</style>
