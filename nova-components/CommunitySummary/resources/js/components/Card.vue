<template>
    <div class="mt-12">
        <loading-card :loading="!loaded" class="summary">
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i" rel="stylesheet">
            <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
            <header>
                <div class="infoAddress">
                    <div class="wrapLogoCommunity">
                        <div v-if="specialOversight" class="icon-blue-lock sprite"
                             v-tooltip="specialOversightNotes"></div>
                        <img v-if="this.community ? this.community.community_logo : null" :src="logoUrl"
                             class="logoCommunity" alt="Logo of Community">
                        <div v-if="this.community ? !this.community.community_logo : null" class="blank-image"></div>
                    </div>
                    <div>
                        <div class="wrap-headline">
                            <h1 class="headline">{{this.communityName}}</h1>
                            <span :class="relationshipStatusClass" v-tooltip="relationshipStatusNotes"></span>

                        </div>
                        <h2 class="subheadline"><a :href="countyFilterUrl" target="_blank">{{this.community ?
                            this.community.COUNTY : ''}} County</a> ({{this.resourceId}})</h2>
                    </div>
                </div>
                <div class="infoPrograms">
                    <div class="wrap-programs">
                        <div class="programs">
                            <h3 class="text-center">Rental<br><span class="text-xs text-80">{{this.community ? (this.community.housing_data ? parseInt(this.community.housing_data.est_long_term_rental).toLocaleString() : 0) : 0}}</span>
                            </h3>
                            <div v-html="rentalBadgeContent"
                                 :class="this.rentalPartner ? 'round-info-green gold-n5' : 'round-info gold-n0'"></div>
                        </div>
                        <div class="programs">
                            <h3 class="text-center">Vacant<br><span class="text-xs text-80">{{this.community ? (this.community.housing_data ? parseInt(this.community.housing_data.est_vacant_total).toLocaleString() : 0) : 0}}</span>
                            </h3>
                            <div v-html="vacantBadgeContent"
                                 :class="this.vacantPartner ? 'round-info-green gold-n5' : 'round-info gold-n0'"></div>
                        </div>
                        <div class="programs">
                            <h3 class="text-center">Foreclosure<br><span class="text-xs text-80">{{parseInt(estForeclosures).toLocaleString()}}</span>
                            </h3>
                            <div v-html="foreclosureBadgeContent"
                                 :class="this.foreclosurePartner ? 'round-info-green gold-n5' : 'round-info gold-n0'"></div>
                        </div>
                    </div>
                    <div class="box-expires">
                        <p class="wrap-expires">Contract<span v-html="contractExpiration"></span></p>
                    </div>
                </div>
            </header>
            <section class="mt-11">
                <div class="communityDetail">
                    <div class="wrap-detailsBox">
                        <div class="detailBox">
                            <div class="wrap-detailBox">
                                <div>
                                    <div class="label-square">
                                        <i class="fa-xs fas fa-square"></i>
                                        Community Size
                                    </div>
                                    <div class="textDetail">{{size}} | {{this.community ? (this.community.housing_data ?
                                        this.community.housing_data.housing_units : '') : ''}} Housing Units
                                    </div>
                                </div>
                                <div>
                                    <div class="label-square">
                                        <i class="fa-xs fas fa-square"></i>
                                        Strong Mayor
                                    </div>
                                    <div class="textDetail">{{strongMayor}}</div>
                                </div>
                                <div>
                                    <div class="label-square">
                                        <i class="fa-xs fas fa-square"></i>
                                        Branding Configurations
                                    </div>
                                    <div v-if="rentalPartner || vacantPartner || foreclosurePartner"
                                         class="table w-full" v-html="brandingConfigTooltip"></div>
                                    <div v-else>N/A</div>
                                </div>
                            </div>
                        </div>
                        <div class="detailBox" style="border: none">
                            <div class="wrap-detailBox">
                                <div>
                                    <div class="label-square">
                                        <i class="fa-xs fas fa-square"></i>
                                        Community Exclusion
                                    </div>
                                    <div class="textDetail">{{communityExclusion}}</div>
                                </div>
                                <div>
                                    <div class="label-square">
                                        <i class="fa-xs fas fa-square"></i>
                                        Relationship Manager
                                    </div>
                                    <div class="textDetail">{{this.community ? (this.community.relationship_managers[0] ? this.community.relationship_managers[0].name : 'No RMs Assigned') : 'No RMs Assigned'}}
                                    </div>
                                </div>
                                <div>
                                    <div class="label-square">
                                        <i class="fa-xs fas fa-square"></i>
                                        Last Update
                                    </div>
                                    <div class="textDetail" v-html="this.lastUpdated"></div>
                                    <br>
                                    <div style="margin-top: -6px; margin-left: -8px"><span id="pending-changes"
                                                                                           v-html="this.pendingChanges"
                                                                                           @click="navigateToChanges"
                                                                                           style="background: #ffd740"
                                                                                           class="pending-changes cursor-pointer rounded-full px-3 py-1 font-semibold">"</span>
                                        Pending Change{{this.pendingChanges === 1 ? "" : "s"}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="detailBox links">
                            <div class="wrap-detailBox">
                                <div class="wrap-links">
                                    <div class="label-square">
                                        <i class="fa-xs fas fa-square"></i>
                                        Community Links
                                    </div>
                                    <div class="group-links">
                                        <div @click="viewCore" class="textLinks pointer">CORE
                                            <i class="fa-xs fas fa-plus-square"></i>
                                        </div>
                                        <div @click="displayLink" class="textLinks pointer">SHARE
                                            <i class="fa-xs fas fa-plus-square"></i>
                                        </div>
                                        <div @click="viewSharepoint" class="textLinks pointer">SHAREPOINT
                                            <i class="fa-xs fas fa-plus-square"></i>
                                        </div>
                                        <div @click="viewRPLanding" class="textLinks pointer">RP LANDING
                                            <i class="fa-xs fas fa-plus-square"></i>
                                        </div>
                                        <div class="textLinks pointer">GOV ADMIN
                                            <i class="fa-xs fas fa-plus-square"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="boxInfo">
                        <div class="wrap-boxInfo">
                            <div class="line"></div>
                            <div class="boxHead">
                                <router-link :to="{ path: stateLink }"
                                >
                                    {{this.community ? (this.community.state ? this.community.state.name : '') : ''}}
                                </router-link>
                            </div>
                            <div class="boxContent">
                                <div class="itemBox">
                                    <div>
                                        <div class="label-boxInfo">Governance:</div>
                                        <div class="textBox">{{governance}}</div>
                                    </div>
                                    <div>
                                        <div class="label-boxInfo">FC Process:</div>
                                        <div class="textBox">{{fcProcess}}</div>
                                    </div>
                                    <div>
                                        <div class="label-boxInfo">Exclude/Concern:</div>
                                        <div class="textBox">{{stateExcluded}}</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </loading-card>
        <br><br>
        <div class="flex mb-4">
            <!---->
            <div class="w-full flex items-center">
                <h1 class="flex-no-shrink text-90 font-normal text-2xl">Tasks/Projects</h1>
                <!---->
                <div class="flex-no-shrink ml-auto mb-6">
                    <a href="javascript:void(0)" v-if="projectDetails == null" @click="createProject" class="btn btn-default btn-primary" dusk="create-button">Create Project</a>
                </div>
            </div>
        </div>
        <div class="w-full flex items-center" id="loader">
            <div class="lds-facebook"><div></div><div></div><div></div></div>
        </div>
        <div v-if="!isLoading" class="relationship-tabs-panel card">
            <div class="w-full" v-if="Template === 1">
                <div v-if="projectDetails">
                    <div class="tabs-wrap border-b-2 border-40 w-full">
                        <div class="tabs flex flex-row overflow-x-auto">
                            <button class="py-5 px-8 border-b-2 focus:outline-none tab text-grey-black font-bold border-primary">
                                {{ projectDetails.data.name }} &nbsp;&nbsp;&nbsp;
                            </button>
                        </div>
                    </div>
                    <div class="add-task-section-wrapper">
                        <div class="section-left">
                            <div class="_btn _btn-default" @click="createNewTaskCounter += 1">
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
                                <span>All Tasks</span>
                                <div class="task-head-box-dropdown nv-dropdown-menu">
                                    <div class="each-box">
                                        <a href="#">All Task</a>
                                    </div>
                                    <div class="each-box">
                                        <a href="#">Incomplete tasks</a>
                                    </div>
                                    <div class="each-box">
                                        <a href="#">Complete Tasks</a>
                                    </div>
                                </div>
                            </div>
                            <div class="_assigned-box">
                                <select class="_custom-select" v-model="taskFilter.assignee" @change="filterTasks" name="">
                                    <option value="">Assignee</option>
                                    <option v-if="users.length > 0" v-for="user in users" :value="user.gid">{{ user.name }}</option>
                                </select>
                            </div>
                            <div class="_assigned-box">
                                <select class="_custom-select" v-model="taskFilter.section" @change="filterTasks" name="">
                                    <option value="">Choose type</option>
                                    <option v-if="sections.length > 0" v-for="section in sections" :value="section.gid">{{ section.name }}</option>
                                </select>
                            </div>
                            <div class="_assigned-box">
                                <flat-pickr
                                    v-model="taskFilter.due_on"
                                    :config="config"
                                    @on-change="filterTasks"
                                    class="w-full form-control form-input-bordered"
                                    placeholder="Due Date"
                                    name="date">
                                </flat-pickr>
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
                                <div class="task-assignee-box border-right-none">
                                    Due Date
                                </div>
                            </div>
                            <div class="task-list-body" v-if="createNewTaskCounter > 0" v-for="i in createNewTaskCounter">
                                <div class="task-name-box cursor-pointer">
                                    <div @click="isTaskComplete == 1 ? isTaskComplete = 0 : isTaskComplete = 1" class="border-radious-icon" :class="{'task-complete': isTaskComplete == 1 ? true : false}">
                                        <svg class="MiniIcon"
                                             viewBox="0 0 24 24">
                                            <path d="M9.5,18.2c-0.4,0.4-1,0.4-1.4,0l-3.8-3.8C4,14,4,13.4,4.3,13s1-0.4,1.4,0l3.1,3.1l8.6-8.6c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 L9.5,18.2z"></path>
                                        </svg>
                                    </div>
                                    <span><input type="text" class="task-body-custom-input"></span>
                                    <div @click="sideBar == 1 ? sideBar = 0 : sideBar = 1" class="detail-option">Detail
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
                                        <span><input type="text" class="assignee-box-input assigned-input"></span>
                                    </div>

                                    <div class="assignee-box-dropdown nv-dropdown-menu">
                                        <div class="each-assignee" v-if="users.length > 0" v-for="user in users">
                                            <div class="profile-img"
                                                 style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                            <div class="name-text">{{ user.name }}</div>
                                        </div>
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
                                            @on-change=""
                                            class="assignee-box-input assigned-input"
                                            name="date">
                                        </flat-pickr>
                                    </span>
                                </div>
                            </div>
                            <div class="collapse-parent collapse-open" v-if="sectionData.length > 0" v-for="section in sectionData">
                                <div class="section-header">
                                    <div class="d-flex-inline cursor-pointer nv-collapse">{{ section[0].name }}
                                        <svg style="enable-background:new 0 0 511.626 511.626;width: 23px;height: 23px;"
                                             class="MiniIcon-right"
                                             focusable="false" viewBox="0 0 32 32">
                                            <path d="M25.9,12.9c-0.5-0.6-1.5-0.7-2.1-0.2L16,19.1l-7.8-6.4c-0.6-0.5-1.6-0.4-2.1,0.2c-0.5,0.6-0.4,1.6,0.2,2.1l8.8,7.2  c0.2,0.2,0.6,0.3,0.9,0.3s0.7-0.1,0.9-0.3l8.8-7.2C26.3,14.5,26.4,13.5,25.9,12.9z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="nv-collapsedown">
                                    <div class="task-list-body border-top-task-list" v-if="section['tasks'].length > 0" v-for="task in section['tasks']">
                                        <div class="task-name-box cursor-pointer">
                                            <div class="border-radious-icon" :class="{'task-complete': task[0].data.completed ? true : false}">
                                                <svg class="MiniIcon"
                                                     viewBox="0 0 24 24">
                                                    <path d="M9.5,18.2c-0.4,0.4-1,0.4-1.4,0l-3.8-3.8C4,14,4,13.4,4.3,13s1-0.4,1.4,0l3.1,3.1l8.6-8.6c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 L9.5,18.2z"></path>
                                                </svg>
                                            </div>
                                            <span><input type="text" class="task-body-custom-input" placeholder="Write a task name" :value="task[0].data.name"></span>
                                            <div @click="showTask(task[0].data.gid)" class="detail-option">Detail
                                                <svg class="MiniIcon-right" viewBox="0 0 24 24">
                                                    <path d="M8.9,20.4c-0.4,0-0.7-0.1-1-0.4c-0.6-0.6-0.7-1.5-0.1-2.1l5.2-5.8L7.8,6C7.3,5.4,7.3,4.4,8,3.9C8.6,3.3,9.5,3.4,10.1,4l6.1,7.1c0.5,0.6,0.5,1.4,0,2l-6.1,6.8C9.8,20.3,9.4,20.4,8.9,20.4z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="task-assignee-box cursor-pointer nv-dropdown" @click="focusInput(event)">
                                            <div class="nv-dropdown-trigger">
                                                <div id="'assignee-logo-id' + task[0].data.gid" class="assignee-box-logo" v-if="task[0].data.assignee == null">
                                                    <svg class="inside-logo" focusable="false" viewBox="0 0 32 32">
                                                        <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                    </svg>
                                                </div>
                                                <span><input type="text" class="assignee-box-input nv-dropdown-trigger"></span>

                                                <div class="assigned-person" v-if="task[0].data.assignee">
                                                    <div class="img-box"  style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                    <div class="text-1">{{ task[0].data.assignee.name }}</div>
                                                </div>
                                            </div>
                                            <div class="assignee-box-dropdown nv-dropdown-menu">
                                                <div class="each-assignee" v-if="users.length > 0" v-for="user in users" :value="user.gid">
                                                    <div class="profile-img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                    <div class="name-text">{{ user.name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="task-date-box cursor-pointer border-right-none">
                                            <div class="assignee-box-logo">
                                                <svg class="inside-logo" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                </svg>
                                            </div>
                                            <span v-if="task[0].data.due_on">{{ task[0].data.due_on }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="task-list-detail-wrapper" id="task-detail" :class="{'hideMe': sideBar == 0 ? true:false}">
                            <div class="loader-io">
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
                                            <span v-if="taskDetails[0].data.completed">Completed</span>
                                            <span v-else="">Mark Complete</span>
                                        </div>
                                    </div>
                                    <div class="section-right _text-right">
                                        <input type="file" id="file" name="file" v-on:change="handleFileUpload(taskDetails[0].data.gid, $event)" style="display: none">
                                        <div class="logo-box" onclick="document.getElementById('file').click()">
                                            <svg class="hide-box-icon" focusable="false" viewBox="0 0 32 32">
                                                <path d="M19,32c-3.9,0-7-3.1-7-7V10c0-2.2,1.8-4,4-4s4,1.8,4,4v9c0,0.6-0.4,1-1,1s-1-0.4-1-1v-9c0-1.1-0.9-2-2-2s-2,0.9-2,2v15c0,2.8,2.2,5,5,5s5-2.2,5-5V10c0-4.4-3.6-8-8-8s-8,3.6-8,8v5c0,0.6-0.4,1-1,1s-1-0.4-1-1v-5C6,4.5,10.5,0,16,0s10,4.5,10,10v15C26,28.9,22.9,32,19,32z"></path>
                                            </svg>
                                        </div>
                                        <div class="logo-box">
                                            <svg class="hide-box-icon" focusable="false" viewBox="0 0 32 32">
                                                <path d="M25,20c-2.4,0-4.4,1.7-4.9,4H11c-3.9,0-7-3.1-7-7v-5h16.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5s-2.2-5-5-5c-2.4,0-4.4,1.7-4.9,4H4V3c0-0.6-0.4-1-1-1S2,2.4,2,3v14c0,5,4,9,9,9h9.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5S27.8,20,25,20z M25,8c1.7,0,3,1.3,3,3s-1.3,3-3,3s-3-1.3-3-3S23.3,8,25,8z M25,28c-1.7,0-3-1.3-3-3s1.3-3,3-3s3,1.3,3,3S26.7,28,25,28z"></path>
                                            </svg>
                                        </div>
                                        <div class="logo-box">
                                            <svg class="hide-box-icon" focusable="false" viewBox="0 0 32 32">
                                                <path d="M9,32c-2.3,0-4.6-0.9-6.4-2.6c-3.5-3.5-3.5-9.2,0-12.7l4-4c0.4-0.4,1-0.4,1.4,0c0.4,0.4,0.4,1,0,1.4l-4,4c-2.7,2.7-2.7,7.2,0,9.9s7.2,2.7,9.9,0l4-4c2.7-2.7,2.7-7.2,0-9.9c-0.8-0.8-1.8-1.4-2.9-1.7c-0.5-0.2-0.8-0.7-0.7-1.3c0.2-0.5,0.7-0.8,1.3-0.7c1.4,0.4,2.7,1.2,3.7,2.2c3.5,3.5,3.5,9.2,0,12.7l-4,4C13.6,31.1,11.3,32,9,32z M16.6,21.6c-0.1,0-0.2,0-0.3,0c-1.4-0.4-2.7-1.2-3.7-2.2c-1.7-1.7-2.6-4-2.6-6.4s0.9-4.7,2.6-6.4l4-4c3.5-3.5,9.2-3.5,12.7,0s3.5,9.2,0,12.7l-4,4c-0.4,0.4-1,0.4-1.4,0s-0.4-1,0-1.4l4-4c2.7-2.7,2.7-7.2,0-9.9S20.7,1.3,18,4l-4,4c-1.3,1.4-2,3.1-2,5s0.7,3.6,2.1,5c0.8,0.8,1.8,1.4,2.9,1.7c0.5,0.2,0.8,0.7,0.7,1.3C17.5,21.4,17.1,21.6,16.6,21.6z"></path>
                                            </svg>
                                        </div>
                                        <div class="logo-box">
                                            <svg class="hide-box-icon" focusable="false" viewBox="0 0 32 32">
                                                <path d="M28.3,4.3c-1.2-1.4-3-2.1-4.9-1.9c-1.3,0.1-2.5,0.8-3.5,1.8L6,18c-0.6,0.6-1.1,1.4-1.4,2.2l-2.2,6.4C2.1,27.5,2.3,28.4,3,29c0.4,0.4,1,0.7,1.6,0.7c0.3,0,0.5,0,0.8-0.1l6.4-2.2c0.8-0.3,1.6-0.8,2.2-1.4l13.9-13.9C30,10,30.1,6.4,28.3,4.3z M4.7,27.7c-0.2,0.1-0.3,0-0.3-0.1c-0.1-0.1-0.1-0.2-0.1-0.3l2-5.8l4.2,4.2L4.7,27.7z M26.4,10.7L12.5,24.6c-0.1,0.1-0.1,0.1-0.2,0.1l-5.1-5.1c0-0.1,0.1-0.1,0.1-0.2l14-13.8c0.7-0.7,1.5-1.1,2.3-1.2c1.2-0.1,2.4,0.3,3.2,1.2C28,7,27.8,9.4,26.4,10.7z"></path>
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
                                    <input type="text" class="input-big" placeholder="Write a task name" v-model="taskDetails[0].data.name">
                                </div>
                                <div class="head-text-section border-bottom-task-list">
                                    <div class="radious-square-input nv-dropdown">
                                        <div class="logo-border">
                                            <svg class="input-icon-1" focusable="false" viewBox="0 0 32 32">
                                                <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                            </svg>
                                        </div>

                                        <input type="text" placeholder="Assignee" :value="taskDetails[0].data.assignee.name" class="input-design">

                                        <!--<div class="assigned-person" v-if="taskDetails[0].data.assignee">
                                            <div class="img-box"  style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                            <div class="text-1">{{ taskDetails[0].data.assignee.name }}</div>
                                        </div>-->

                                        <div class="assignee-box-dropdown nv-dropdown-menu">
                                            <div class="each-assignee" v-if="users.length > 0" v-for="user in users">
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
                                            @on-change="inlineTaskUpdateNew(taskDetails[0].data.gid, 'due_on', $event)"
                                            class="input-design"
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
                                    <textarea name="" class="custom-text-area" cols="30" rows="5" placeholder="Description" v-model="taskDetails[0].data.notes"></textarea>
                                </div>
                                <div class="head-text-section _position-relative border-bottom-task-list">
                                    <div class="_input-logo">
                                        <svg class="t-logo" focusable="false" viewBox="0 0 32 32">
                                            <path d="M10,13.5c0.8,0,1.5,0.7,1.5,1.5s-0.7,1.5-1.5,1.5S8.5,15.8,8.5,15S9.2,13.5,10,13.5z M23,14h-8c-0.6,0-1,0.4-1,1s0.4,1,1,1h8c0.6,0,1-0.4,1-1S23.6,14,23,14z M23,20h-8c-0.6,0-1,0.4-1,1s0.4,1,1,1h8c0.6,0,1-0.4,1-1S23.6,20,23,20z M10,19.5c0.8,0,1.5,0.7,1.5,1.5s-0.7,1.5-1.5,1.5S8.5,21.8,8.5,21S9.2,19.5,10,19.5z M24,2h-2.2c-0.4-1.2-1.5-2-2.8-2h-6c-1.3,0-2.4,0.8-2.8,2H8C4.7,2,2,4.7,2,8v18c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M13,2h6c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1h-6c-0.6,0-1-0.4-1-1V3C12,2.4,12.4,2,13,2z M28,26c0,2.2-1.8,4-4,4H8c-2.2,0-4-1.8-4-4V8c0-2.2,1.8-4,4-4h2v1c0,1.7,1.3,3,3,3h6c1.7,0,3-1.3,3-3V4h2c2.2,0,4,1.8,4,4V26z"></path>
                                        </svg>
                                    </div>
                                    <input name="" class="custom-input-add-project" placeholder="Add to Project">
                                    <div class="new-task" v-if="taskDetails.subTasks.length > 0" v-for="(t, index) in taskDetails.subTasks">
                                        <div class="border-radious-icon" :class="{'task-complete': t[0].data.completed ? true : false}">
                                            <svg class="MiniIcon"
                                                 viewBox="0 0 24 24">
                                                <path d="M9.5,18.2c-0.4,0.4-1,0.4-1.4,0l-3.8-3.8C4,14,4,13.4,4.3,13s1-0.4,1.4,0l3.1,3.1l8.6-8.6c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 L9.5,18.2z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" class="new-task-input" v-model="taskDetails.subTasks[index][0].data.name">
                                        <div class="new-task-logo">
                                            <div class="logo-1 cursor-pointer nv-dropdown">
                                                <svg class="_icon" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                </svg>
                                                <div class="assignee-box-dropdown nv-dropdown-menu">
                                                    <div class="each-assignee" v-if="users.length > 0" v-for="user in users" :value="user.gid">
                                                        <div class="profile-img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                        <div class="name-text">{{ user.name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="logo-2 cursor-pointer">
                                                <svg class="_icon" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                </svg>
                                            </div>
                                            <div class="logo-3 cursor-pointer">
                                                <svg class="_icon" focusable="false"
                                                     viewBox="0 0 32 32">
                                                    <path d="M5,31c-0.1,0-0.3,0-0.4-0.1C4.2,30.7,4,30.4,4,30v-7.1c-2.5-2.3-4-5.5-4-8.9C0,7.4,5.4,2,12,2h8c6.6,0,12,5.4,12,12 s-5.4,12-12,12h-8c-0.1,0-0.3,0-0.4,0l-5.9,4.8C5.4,30.9,5.2,31,5,31z M12,4C6.5,4,2,8.5,2,14c0,3,1.3,5.8,3.6,7.7C5.9,21.9,6,22.2,6,22.5v5.4l4.6-3.7C10.8,24,11,24,11.3,24h0.1c0.2,0,0.4,0,0.6,0h8c5.5,0,10-4.5,10-10S25.5,4,20,4 C20,4,12,4,12,4z"></path>
                                                </svg>
                                            </div>
                                            <div class="logo-3">
                                                <svg class="_icon" focusable="false"
                                                     viewBox="0 0 32 32">
                                                    <path d="M23.2,16c0,0.3-0.1,0.7-0.3,0.9l-9,11c-0.5,0.6-1.5,0.7-2.1,0.2s-0.7-1.5-0.2-2.1l8.2-10L11.6,6c-0.5-0.6-0.4-1.6,0.2-2.1s1.6-0.4,2.1,0.2l9,11C23.1,15.3,23.2,15.7,23.2,16z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="head-text-section border-bottom-task-list" v-if="taskDetails.comments.data.length > 0" v-for="comment in taskDetails.comments.data">
                                    <div class="profile-img">
                                        <div class="_img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                    </div>
                                    <div class="detail-text-area">
                                        <span><a class="lnk-text" href="#">{{ comment.created_by.name }} </a>{{ comment.text }}</span>
                                        <span class="small-text"><vue-moments-ago prefix="" suffix="ago" :date="comment.created_at"></vue-moments-ago></span>
                                    </div>
                                </div>
                                <div class="head-text-section bg-light">
                                    <div class="profile-img">
                                        <div class="_img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                    </div>
                                    <textarea @change="storeTaskComment(taskDetails[0].data.gid)" v-model="taskComment" class="custom-text-area-chat" cols="30" rows="5" placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="task-details-wrapper" v-else="">
                                <div class="add-task-section-wrapper">
                                    <div class="section-left">
                                        <div :class="{'_btn': true, '_btn-default':true, '_btn _btn-default-active': isMarkComplete == 1 ? true : false}">
                                            <svg class="MiniIcon-custom" viewBox="0 0 24 24">
                                                <path d="M9.2,20c-0.5,0.5-1.3,0.5-1.9,0l-5.1-5.1c-0.4-0.5-0.4-1.3,0-1.9c0.4-0.5,1.3-0.5,1.9,0l4.1,4.1L19.7,5.7 c0.5-0.5,1.3-0.5,1.9,0s0.5,1.3,0,1.9L9.2,20z"></path>
                                            </svg>
                                            <span v-if="isMarkComplete == 0">Mark Complete</span>
                                            <span v-if="isMarkComplete == 1">Completed</span>
                                        </div>
                                    </div>
                                    <div class="section-right _text-right">
                                        <div class="logo-box">
                                            <svg class="hide-box-icon" focusable="false" viewBox="0 0 32 32">
                                                <path d="M19,32c-3.9,0-7-3.1-7-7V10c0-2.2,1.8-4,4-4s4,1.8,4,4v9c0,0.6-0.4,1-1,1s-1-0.4-1-1v-9c0-1.1-0.9-2-2-2s-2,0.9-2,2v15c0,2.8,2.2,5,5,5s5-2.2,5-5V10c0-4.4-3.6-8-8-8s-8,3.6-8,8v5c0,0.6-0.4,1-1,1s-1-0.4-1-1v-5C6,4.5,10.5,0,16,0s10,4.5,10,10v15C26,28.9,22.9,32,19,32z"></path>
                                            </svg>
                                        </div>
                                        <div class="logo-box">
                                            <svg class="hide-box-icon" focusable="false" viewBox="0 0 32 32">
                                                <path d="M25,20c-2.4,0-4.4,1.7-4.9,4H11c-3.9,0-7-3.1-7-7v-5h16.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5s-2.2-5-5-5c-2.4,0-4.4,1.7-4.9,4H4V3c0-0.6-0.4-1-1-1S2,2.4,2,3v14c0,5,4,9,9,9h9.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5S27.8,20,25,20z M25,8c1.7,0,3,1.3,3,3s-1.3,3-3,3s-3-1.3-3-3S23.3,8,25,8z M25,28c-1.7,0-3-1.3-3-3s1.3-3,3-3s3,1.3,3,3S26.7,28,25,28z"></path>
                                            </svg>
                                        </div>
                                        <div class="logo-box">
                                            <svg class="hide-box-icon" focusable="false" viewBox="0 0 32 32">
                                                <path d="M9,32c-2.3,0-4.6-0.9-6.4-2.6c-3.5-3.5-3.5-9.2,0-12.7l4-4c0.4-0.4,1-0.4,1.4,0c0.4,0.4,0.4,1,0,1.4l-4,4c-2.7,2.7-2.7,7.2,0,9.9s7.2,2.7,9.9,0l4-4c2.7-2.7,2.7-7.2,0-9.9c-0.8-0.8-1.8-1.4-2.9-1.7c-0.5-0.2-0.8-0.7-0.7-1.3c0.2-0.5,0.7-0.8,1.3-0.7c1.4,0.4,2.7,1.2,3.7,2.2c3.5,3.5,3.5,9.2,0,12.7l-4,4C13.6,31.1,11.3,32,9,32z M16.6,21.6c-0.1,0-0.2,0-0.3,0c-1.4-0.4-2.7-1.2-3.7-2.2c-1.7-1.7-2.6-4-2.6-6.4s0.9-4.7,2.6-6.4l4-4c3.5-3.5,9.2-3.5,12.7,0s3.5,9.2,0,12.7l-4,4c-0.4,0.4-1,0.4-1.4,0s-0.4-1,0-1.4l4-4c2.7-2.7,2.7-7.2,0-9.9S20.7,1.3,18,4l-4,4c-1.3,1.4-2,3.1-2,5s0.7,3.6,2.1,5c0.8,0.8,1.8,1.4,2.9,1.7c0.5,0.2,0.8,0.7,0.7,1.3C17.5,21.4,17.1,21.6,16.6,21.6z"></path>
                                            </svg>
                                        </div>
                                        <div class="logo-box">
                                            <svg class="hide-box-icon" focusable="false" viewBox="0 0 32 32">
                                                <path d="M28.3,4.3c-1.2-1.4-3-2.1-4.9-1.9c-1.3,0.1-2.5,0.8-3.5,1.8L6,18c-0.6,0.6-1.1,1.4-1.4,2.2l-2.2,6.4C2.1,27.5,2.3,28.4,3,29c0.4,0.4,1,0.7,1.6,0.7c0.3,0,0.5,0,0.8-0.1l6.4-2.2c0.8-0.3,1.6-0.8,2.2-1.4l13.9-13.9C30,10,30.1,6.4,28.3,4.3z M4.7,27.7c-0.2,0.1-0.3,0-0.3-0.1c-0.1-0.1-0.1-0.2-0.1-0.3l2-5.8l4.2,4.2L4.7,27.7z M26.4,10.7L12.5,24.6c-0.1,0.1-0.1,0.1-0.2,0.1l-5.1-5.1c0-0.1,0.1-0.1,0.1-0.2l14-13.8c0.7-0.7,1.5-1.1,2.3-1.2c1.2-0.1,2.4,0.3,3.2,1.2C28,7,27.8,9.4,26.4,10.7z"></path>
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
                                    <input type="text" class="input-big" placeholder="Write a task name" v-model="taskName">
                                </div>
                                <div class="head-text-section border-bottom-task-list">
                                    <div class="radious-square-input">
                                        <div class="logo-border">
                                            <svg class="input-icon-1" focusable="false" viewBox="0 0 32 32">
                                                <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" placeholder="Unassigne" class="input-design">
                                    </div>
                                    <div class="radious-square-input">
                                        <div class="logo-border">
                                            <svg class="input-icon-2" focusable="false" viewBox="0 0 32 32">
                                                <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" placeholder="Unassigne" class="input-design">
                                    </div>
                                </div>
                                <div class="head-text-section">
                                    <div class="text-area-logo">
                                        <svg class="t-logo" focusable="false" viewBox="0 0 32 32">
                                            <path d="M31,8H1C0.4,8,0,7.6,0,7s0.4-1,1-1h30c0.6,0,1,0.4,1,1S31.6,8,31,8z M23,14H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,14,23,14z M27,20H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h26c0.6,0,1,0.4,1,1S27.6,20,27,20z M19,26H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h18c0.6,0,1,0.4,1,1S19.6,26,19,26z"></path>
                                        </svg>
                                    </div>
                                    <textarea name="" v-model="taskDesc" class="custom-text-area" cols="30" rows="5" placeholder="Description"></textarea>
                                </div>
                                <div class="head-text-section _position-relative border-bottom-task-list">
                                    <div class="_input-logo">
                                        <svg class="t-logo" focusable="false" viewBox="0 0 32 32">
                                            <path d="M10,13.5c0.8,0,1.5,0.7,1.5,1.5s-0.7,1.5-1.5,1.5S8.5,15.8,8.5,15S9.2,13.5,10,13.5z M23,14h-8c-0.6,0-1,0.4-1,1s0.4,1,1,1h8c0.6,0,1-0.4,1-1S23.6,14,23,14z M23,20h-8c-0.6,0-1,0.4-1,1s0.4,1,1,1h8c0.6,0,1-0.4,1-1S23.6,20,23,20z M10,19.5c0.8,0,1.5,0.7,1.5,1.5s-0.7,1.5-1.5,1.5S8.5,21.8,8.5,21S9.2,19.5,10,19.5z M24,2h-2.2c-0.4-1.2-1.5-2-2.8-2h-6c-1.3,0-2.4,0.8-2.8,2H8C4.7,2,2,4.7,2,8v18c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M13,2h6c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1h-6c-0.6,0-1-0.4-1-1V3C12,2.4,12.4,2,13,2z M28,26c0,2.2-1.8,4-4,4H8c-2.2,0-4-1.8-4-4V8c0-2.2,1.8-4,4-4h2v1c0,1.7,1.3,3,3,3h6c1.7,0,3-1.3,3-3V4h2c2.2,0,4,1.8,4,4V26z"></path>
                                        </svg>
                                    </div>
                                    <input name="" v-model="taskProject" class="custom-input-add-project"
                                           placeholder="Add to Project">
                                    <div class="new-task">
                                        <div class="border-radious-icon" :class="{'task-complete': isTaskComplete == 1 ? true : false}">
                                            <svg class="MiniIcon"
                                                 viewBox="0 0 24 24">
                                                <path d="M9.5,18.2c-0.4,0.4-1,0.4-1.4,0l-3.8-3.8C4,14,4,13.4,4.3,13s1-0.4,1.4,0l3.1,3.1l8.6-8.6c0.4-0.4,1-0.4,1.4,0s0.4,1,0,1.4 L9.5,18.2z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" class="new-task-input">
                                        <div class="new-task-logo">
                                            <div class="logo-1 cursor-pointer nv-dropdown">
                                                <svg class="_icon" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                </svg>
                                                <div class="assignee-box-dropdown nv-dropdown-menu">
                                                    <div class="each-assignee">
                                                        <div class="profile-img"
                                                             style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                        <div class="name-text">Shadin Rana</div>
                                                    </div>
                                                    <div class="each-assignee">
                                                        <div class="profile-img"
                                                             style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                        <div class="name-text">Shadin Rana</div>
                                                    </div>
                                                    <div class="each-assignee">
                                                        <div class="profile-img"
                                                             style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                                        <div class="name-text">Shadin Rana</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="logo-2 cursor-pointer">
                                                <svg class="_icon" focusable="false" viewBox="0 0 32 32">
                                                    <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                </svg>
                                            </div>
                                            <div class="logo-3 cursor-pointer">
                                                <svg class="_icon" focusable="false"
                                                     viewBox="0 0 32 32">
                                                    <path d="M5,31c-0.1,0-0.3,0-0.4-0.1C4.2,30.7,4,30.4,4,30v-7.1c-2.5-2.3-4-5.5-4-8.9C0,7.4,5.4,2,12,2h8c6.6,0,12,5.4,12,12 s-5.4,12-12,12h-8c-0.1,0-0.3,0-0.4,0l-5.9,4.8C5.4,30.9,5.2,31,5,31z M12,4C6.5,4,2,8.5,2,14c0,3,1.3,5.8,3.6,7.7C5.9,21.9,6,22.2,6,22.5v5.4l4.6-3.7C10.8,24,11,24,11.3,24h0.1c0.2,0,0.4,0,0.6,0h8c5.5,0,10-4.5,10-10S25.5,4,20,4 C20,4,12,4,12,4z"></path>
                                                </svg>
                                            </div>
                                            <div class="logo-3">
                                                <svg class="_icon" focusable="false"
                                                     viewBox="0 0 32 32">
                                                    <path d="M23.2,16c0,0.3-0.1,0.7-0.3,0.9l-9,11c-0.5,0.6-1.5,0.7-2.1,0.2s-0.7-1.5-0.2-2.1l8.2-10L11.6,6c-0.5-0.6-0.4-1.6,0.2-2.1s1.6-0.4,2.1,0.2l9,11C23.1,15.3,23.2,15.7,23.2,16z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="head-text-section border-bottom-task-list">
                                    <div class="profile-img">
                                        <div class="_img"
                                             style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                    </div>
                                    <div class="detail-text-area">
                                        <span><a class="lnk-text" href="#">Sadhin Rana </a>created this task.</span>
                                        <span class="small-text">8 minutes ago</span>
                                    </div>
                                    <div class="detail-text-area">
                                        <span class="small-text">Sadhin Rana added to <a class="lnk-text" href="#">Project 1</a> 8 minutes ago</span>
                                    </div>
                                </div>
                                <div class="head-text-section bg-light">
                                    <div class="profile-img">
                                        <div class="_img" style="background-image: url('https://www.logolynx.com/images/logolynx/03/039b004617d1ef43cf1769aae45d6ea2.png')"></div>
                                    </div>
                                    <textarea name="" class="custom-text-area-chat" cols="30" rows="5" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div v-if="projectDetails" class="tab-content" :class="projectDetails.data.name">
                        <div class="px-6 py-3">
                            <div class="flex border-b border-40 remove-bottom-border">
                                <div class="overflow-hidden overflow-x-auto relative w-full">
                                    <table class="table w-full">
                                        <thead>
                                        <tr>
                                            <th class="text-left">
                                                <a href="javascript:void(0)" @click="createTask" class="btn btn-default btn-primary" dusk="create-button">Create</a>
                                            </th>
                                            <th class="text-left">
                                                <div class="remove-bottom-border">
                                                    <div class="flex">
                                                        <div class="flex w-full">
                                                            <div class="py-6 px-8">
                                                                <label for="name" class="inline-block text-80 pt-2 leading-tight">Assigned To</label>
                                                            </div>
                                                            <div class="py-6 px-8">
                                                                <select v-model="taskFilter.assignee" @change="filterTasks" dusk="attachable-select" data-testid="workspace-select" name="assignee" class="form-control form-select mb-3 w-full">
                                                                    <option value="">Choose Assigned To</option>
                                                                    <option v-if="users.length > 0" v-for="user in users" :value="user.gid">{{ user.name }}</option>
                                                                </select>
                                                                <div class="help-text help-text mt-2" v-if="errors.assignee"><div class="text-danger">{{ errors.assignee[0] }}</div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" v-model="taskFilter.complete" @change="filterTasks">Complete
                                                </label>
                                            </th>
                                            <th class="text-left" colspan="2">
                                                <div class="remove-bottom-border">
                                                    <div class="flex">
                                                        <div class="flex w-full">
                                                            <div class="w-1/5 py-6 px-8">
                                                                <label for="name" class="inline-block text-80 pt-2 leading-tight">Type</label>
                                                            </div>
                                                            <div class="py-6 px-8">
                                                                <select v-model="taskFilter.section" @change="filterTasks" dusk="attachable-select" data-testid="workspace-select" name="assignee" class="form-control form-select mb-3 w-full">
                                                                    <option value="">Choose Type</option>
                                                                    <option v-if="sections.length > 0" v-for="section in sections" :value="section.gid">{{ section.name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                <div class="remove-bottom-border">
                                                    <div class="flex">
                                                        <div class="flex w-full">
                                                            <div class="py-6 px-8">
                                                                <label for="name" class="inline-block text-80 pt-2 leading-tight">Due Date</label>
                                                            </div>
                                                            <div class="py-6 px-8">
                                                                <flat-pickr
                                                                    v-model="taskFilter.due_on"
                                                                    :config="config"
                                                                    @on-change="filterTasks"
                                                                    class="w-full form-control form-input-bordered"
                                                                    placeholder="Select date"
                                                                    name="date">
                                                                </flat-pickr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                <div class="relative h-9 flex-no-shrink mb-6"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="search" role="presentation" class="fill-current absolute search-icon-center ml-3 text-70"><path fill-rule="nonzero" d="M14.32 12.906l5.387 5.387a1 1 0 0 1-1.414 1.414l-5.387-5.387a8 8 0 1 1 1.414-1.414zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path></svg> <input data-testid="search-input" dusk="search" v-model="taskFilter.name" @change="keyTyping" @keyup="keyTyping" placeholder="Search" type="search" class="appearance-none form-search w-search pl-search shadow"></div>
                                            </th>
                                        </tr>
                                        </thead>
                                    </table>
                                    <div class="py-3">
                                        <div class="flex">
                                            <div class="w-full">
                                                <table class="table w-full">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-left">SL</th>
                                                        <th class="text-left">Task</th>
                                                        <th class="text-left">Assignee</th>
                                                        &lt;!&ndash;<th class="text-left">Type</th>&ndash;&gt;
                                                        <th class="text-left">Due Date</th>
                                                        &lt;!&ndash;<th class="text-left">Description</th>
                                                        <th class="text-left">Complete</th>&ndash;&gt;
                                                        <th class="text-right">

                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(t,index) in tasks" v-if="tasks.length > 0 && showMe == 1">
                                                        <td v-text="index+1"></td>
                                                        <td>
                                                            <div @click="editThisQuick(index)" v-if="t.editStatus == undefined || t.editStatus !== 1">{{ t.data.name }}</div>
                                                            <div class="remove-bottom-border" v-if="t.editStatus != undefined && t.editStatus == 1">
                                                                <div class="flex">
                                                                    <div class="flex w-full">
                                                                        <div class="py-6">
                                                                            <input dusk="name" type="text" placeholder="Task Name" :value="t.data.name"
                                                                                   @blur="editThisQuick(index)"
                                                                                   @change="inlineTaskUpdate(index, 'name', $event)" class="w-full form-control form-input form-input-bordered">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div @click="editThisQuick(index)" v-if="(t.data.assignee != null && t.editStatus == undefined) || (t.data.assignee != null && t.editStatus !== 1)">{{ t.data.assignee.name }}</div>
                                                            <div @click="editThisQuick(index)" v-else="">None</div>
                                                            <div class="remove-bottom-border" v-if="t.editStatus != undefined && t.editStatus == 1">
                                                                <div class="flex">
                                                                    <div class="flex w-full">
                                                                        <div class="py-6">
                                                                            <select @change="editThisQuick(index);inlineTaskUpdate(index, 'assignee', $event)" dusk="attachable-select" data-testid="workspace-select" name="assignee" class="form-control form-select mb-3 w-full">
                                                                                <option value="" disabled>Choose Assigned To</option>
                                                                                <option v-for="user in users" :value="user.gid" v-if="t.data.assignee.gid == user.gid" selected>{{ user.name }}</option>
                                                                                <option :value="user.gid" v-else="">{{ user.name }}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        &lt;!&ndash;<td>
                                                            <div @click="editThisQuick(index)" v-if="t.editStatus == undefined || t.editStatus !== 1">{{ t.data.memberships[0].section.name }}</div>
                                                            <div class="remove-bottom-border" v-if="t.editStatus != undefined && t.editStatus == 1">
                                                                <div class="flex">
                                                                    <div class="flex w-full">
                                                                        <div class="py-6">
                                                                            <select dusk="attachable-select" @blur="editThisQuick(index)" @change="editThisQuick(index);inlineTaskUpdate(index, 'section', $event)" data-testid="workspace-select" name="section" class="form-control form-select mb-3 w-full">
                                                                                <option value="" disabled="disabled">Choose Type</option>
                                                                                <option v-for="section in sections" :value="section.gid" v-if="t.data.memberships[0].section.gid == section.gid" selected>{{ section.name }}</option>
                                                                                <option :value="section.gid" v-else="">{{ section.name }}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>&ndash;&gt;
                                                        <td>
                                                            <div @click="editThisQuick(index)" v-if="t.editStatus == undefined || t.editStatus !== 1">{{ t.data.due_on }}</div>
                                                            <div class="remove-bottom-border" v-if="t.editStatus != undefined && t.editStatus == 1">
                                                                <div class="flex">
                                                                    <div class="flex w-full">
                                                                        <div class="py-6">
                                                                            <flat-pickr
                                                                                :value="t.data.due_on"
                                                                                :config="config"
                                                                                @on-blur="editThisQuick(index)"
                                                                                @on-change="inlineTaskUpdate(index, 'due_on', $event)"
                                                                                class="w-full form-control form-input-bordered"
                                                                                placeholder="Select date"
                                                                                name="due_on">
                                                                            </flat-pickr>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        &lt;!&ndash;<td>
                                                            <div @click="editThisQuick(index)" v-if="t.editStatus == undefined || t.editStatus !== 1">{{ t.data.notes }}</div>
                                                            <div class="remove-bottom-border" v-if="t.editStatus != undefined && t.editStatus == 1">
                                                                <div class="flex">
                                                                    <div class="flex w-full">
                                                                        <div class="py-6">
                                                                            <textarea @blur="editThisQuick(index)" @change="inlineTaskUpdate(index, 'notes', $event)" dusk="title" rows="5" class="w-full form-control form-input form-input-bordered py-3 h-auto">{{ t.data.notes }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" v-if="t.data.completed" @change="inlineTaskUpdate(index, 'completed', $event)" checked>
                                                            <input type="checkbox" v-else="" @change="inlineTaskUpdate(index, 'completed', $event)">
                                                        </td>&ndash;&gt;
                                                        <td class="text-right">
                                                            <span><a @click="showTask(t.data.gid)" class="cursor-pointer text-70 hover:text-primary mr-3" dusk="13-view-button" title="View"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 16" aria-labelledby="view" role="presentation" class="fill-current"><path d="M16.56 13.66a8 8 0 0 1-11.32 0L.3 8.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95-.01.01zm-9.9-1.42a6 6 0 0 0 8.48 0L19.38 8l-4.24-4.24a6 6 0 0 0-8.48 0L2.4 8l4.25 4.24h.01zM10.9 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path></svg></a></span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="w-full pl-3" id="taskDetails" style="display: none">
                                                <div v-if="taskDetails">
                                                    <div class="flex border-b border-40 pb-3">
                                                        &lt;!&ndash;&ndash;&gt;
                                                        <div class="w-full flex items-center">
                                                            <a href="javascript:void(0)" v-if="taskDetails[0].data.completed" onclick="document.getElementById('taskDetailsCompleteness').click()" class="btn btn-default btn-success" dusk="create-button"><i class="fa fa-check"></i> Completed</a>
                                                            <a href="javascript:void(0)" v-else="" onclick="document.getElementById('taskDetailsCompleteness').click()" class="btn btn-default btn-primary" dusk="create-button"><i class="fa fa-check"></i> Mark as complete</a>
                                                            <input type="checkbox" v-if="taskDetails[0].data.completed" @click="inlineTaskUpdateNew(taskDetails[0].data.gid, 'completed', $event)" id="taskDetailsCompleteness" style="display:none;" checked>
                                                            <input type="checkbox" v-if="" @click="inlineTaskUpdateNew(taskDetails[0].data.gid, 'completed', $event)" id="taskDetailsCompleteness" style="display:none;">
                                                            &lt;!&ndash;&ndash;&gt;
                                                            <div class="flex-no-shrink ml-auto mb-6">
                                                                <input type="file" id="file" name="file" v-on:change="handleFileUpload(taskDetails[0].data.gid, $event)" style="display: none">
                                                                <a onclick="document.getElementById('file').click()" class="cursor-pointer text-70 hover:text-primary mr-3" dusk="13-view-button" title="Attach file"><i class="fa fa-paperclip"></i></a>
                                                                <span><a href="javascript:void(0)" @click="createNewSubTask = true" class="cursor-pointer text-70 hover:text-primary mr-3" dusk="1-subtasks-button" title="Add subtasks"><svg width="22" height="18" focusable="false" viewBox="0 0 32 32" aria-labelledby="edit" role="presentation" class="fill-current"><path d="M25,20c-2.4,0-4.4,1.7-4.9,4H11c-3.9,0-7-3.1-7-7v-5h16.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5s-2.2-5-5-5c-2.4,0-4.4,1.7-4.9,4H4V3c0-0.6-0.4-1-1-1S2,2.4,2,3v14c0,5,4,9,9,9h9.1c0.5,2.3,2.5,4,4.9,4c2.8,0,5-2.2,5-5S27.8,20,25,20z M25,8c1.7,0,3,1.3,3,3s-1.3,3-3,3s-3-1.3-3-3S23.3,8,25,8z M25,28c-1.7,0-3-1.3-3-3s1.3-3,3-3s3,1.3,3,3S26.7,28,25,28z"></path></svg></a></span>
                                                                <a @click="editTask(taskDetails[0].data.gid)" class="cursor-pointer text-70 hover:text-primary mr-3" dusk="1-edit-button"
                                                                   title="Edit">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                                         viewBox="0 0 20 20" aria-labelledby="edit" role="presentation"
                                                                         class="fill-current">
                                                                        <path
                                                                            d="M4.3 10.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H5a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM6 14h2.59l9-9L15 2.41l-9 9V14zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2h6a1 1 0 1 1 0 2H2v14h14v-6z"></path>
                                                                    </svg>
                                                                </a>
                                                                <a title="Delete" @click="deleteTask(taskDetails[0].data.gid)"
                                                                   class="appearance-none cursor-pointer text-70 hover:text-danger mr-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                                         viewBox="0 0 20 20" aria-labelledby="delete" role="presentation"
                                                                         class="fill-current">
                                                                        <path fill-rule="nonzero"
                                                                              d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"></path>
                                                                    </svg>
                                                                </a>
                                                                <a onclick="document.getElementById('taskDetails').style.display = 'none'" class="appearance-none cursor-pointer text-70 hover:text-danger mr-3" tabindex="0" role="button" aria-disabled="false" aria-label="Close details"><svg class="fill-current" width="20" height="20" focusable="false" viewBox="0 0 32 32"><path d="M2,14.5h18.4l-7.4-7.4c-0.6-0.6-0.6-1.5,0-2.1c0.6-0.6,1.5-0.6,2.1,0l10,10c0.6,0.6,0.6,1.5,0,2.1l-10,10c-0.3,0.3-0.7,0.4-1.1,0.4c-0.4,0-0.8-0.1-1.1-0.4c-0.6-0.6-0.6-1.5,0-2.1l7.4-7.4H2c-0.8,0-1.5-0.7-1.5-1.5C0.5,15.3,1.2,14.5,2,14.5z M28,3.5C28,2.7,28.7,2,29.5,2S31,2.7,31,3.5v25c0,0.8-0.7,1.5-1.5,1.5S28,29.3,28,28.5V3.5z"></path></svg></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex">
                                                        <div class="w-full flex items-center">
                                                            <div class="py-3">
                                                                <h2 id="taskNameHeader" class="flex-no-shrink text-90 font-normal text-2xl" onclick="this.style.display = 'none';document.getElementById('taskName').style.display = 'block';document.getElementById('taskDetailsName').focus();">{{ taskDetails[0].data.name }}</h2>
                                                            </div>
                                                            <div class="remove-bottom-border" id="taskName" style="display: none">
                                                                <div class="flex">
                                                                    <div class="flex w-full">
                                                                        <div class="py-6">
                                                                            <input dusk="name" id="taskDetailsName" type="text" placeholder="Task Name" :value="taskDetails[0].data.name" onblur="document.getElementById('taskName').style.display = 'none';document.getElementById('taskNameHeader').style.display = 'block';" @change="inlineTaskUpdateNew(taskDetails[0].data.gid, 'name', $event)" class="w-full form-control form-input form-input-bordered">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex border-b border-40 pb-3">
                                                        <div class="w-1/2">
                                                            <small>Assigned To</small>
                                                            <p id="taskAssigneeHeader" onclick="this.style.display = 'none';document.getElementById('taskAssignee').style.display = 'block';document.getElementById('taskDetailsAssigned').focus();">{{ taskDetails[0].data.assignee.name }}</p>
                                                            <div class="remove-bottom-border" id="taskAssignee" style="display: none">
                                                                <div class="flex">
                                                                    <div class="flex w-full">
                                                                        <div class="py-6">
                                                                            <select id="taskDetailsAssigned" onblur="document.getElementById('taskAssignee').style.display = 'none';document.getElementById('taskAssigneeHeader').style.display = 'block';" @change="inlineTaskUpdateNew(taskDetails[0].data.gid, 'assignee', $event)" dusk="attachable-select" data-testid="workspace-select" name="assignee" class="form-control form-select mb-3 w-full">
                                                                                <option value="" disabled>Choose Assigned To</option>
                                                                                <option v-for="user in users" :value="user.gid" v-if="taskDetails[0].data.assignee.gid == user.gid" selected>{{ user.name }}</option>
                                                                                <option :value="user.gid" v-else="">{{ user.name }}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="w-1/2">
                                                            <small>Due Date</small>
                                                            <p id="taskDueOnHeader" onclick="this.style.display = 'none';document.getElementById('taskDueOn').style.display = 'block';">{{ taskDetails[0].data.due_on }}</p>
                                                            <div class="remove-bottom-border" id="taskDueOn" style="display: none">
                                                                <div class="flex">
                                                                    <div class="flex w-full">
                                                                        <div class="py-6">
                                                                            <flat-pickr
                                                                                :value="taskDetails[0].data.due_on"
                                                                                :config="{config}"
                                                                                @on-change="inlineTaskUpdateNew(taskDetails[0].data.gid, 'due_on', $event)"
                                                                                @on-close="viewToggle"
                                                                                class="w-full form-control form-input-bordered"
                                                                                autofocus="true"
                                                                                placeholder="Select date"
                                                                                name="due_on">
                                                                            </flat-pickr>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex">
                                                        <div class="w-full flex items-center">
                                                            <div class="py-3" style="width: 100%;">
                                                                <p id="taskNotesHeader" onclick="this.style.display = 'none';document.getElementById('taskNotes').style.display = 'block';document.getElementById('taskDetailsNotes').focus();">{{ taskDetails[0].data.notes }}</p>
                                                                <div class="remove-bottom-border" id="taskNotes" style="display: none">
                                                                    <div class="flex">
                                                                        <div class="flex w-full">
                                                                            <div class="py-6" style="width: 100%;">
                                                                                <textarea id="taskDetailsNotes" onblur="document.getElementById('taskNotes').style.display = 'none';document.getElementById('taskNotesHeader').style.display = 'block';" @change="inlineTaskUpdateNew(taskDetails[0].data.gid, 'notes', $event)" dusk="title" rows="5" class="w-full form-control form-input form-input-bordered py-3 h-auto">{{ taskDetails[0].data.notes }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex border-b border-40">
                                                        <table class="table w-full">
                                                            <tbody>
                                                            <tr v-if="taskDetails.subTasks.length > 0" v-for="(t, index) in taskDetails.subTasks">
                                                                <td v-text="index+1"></td>
                                                                <td>
                                                                    <span>
                                                                        <a v-if="t[0].data.completed" onclick="document.getElementById('subTaskComplete').click()" class="cursor-pointer text-70 text-success-dark hover:text-success-light mr-3" title="Complete"><i class="fa fa-check-circle"></i>
                                                                        </a>
                                                                        <a v-else="" onclick="document.getElementById('subTaskComplete').click()" class="cursor-pointer text-70 text-primary-dark hover:text-primary-light mr-3" title="Mark as complete"><i class="fa fa-check-circle"></i>
                                                                        </a>
                                                                    </span>
                                                                    <input type="checkbox" id="subTaskComplete" v-if="t[0].data.completed" @click="inlineSubTaskUpdate(index, 'completed', $event)" checked style="display: none">
                                                                    <input type="checkbox" id="subTaskComplete" v-else="" @click="inlineSubTaskUpdate(index, 'completed', $event)" style="display: none">
                                                                    <div id="subTaskNotesHeader" onclick="this.style.display = 'none';document.getElementById('subTaskNotes').style.display = 'block';document.getElementById('subTaskNotesInput').focus();">{{ t[0].data.name }}</div>
                                                                    <div class="remove-bottom-border" id="subTaskNotes" style="display: none">
                                                                        <div class="flex">
                                                                            <div class="flex w-full">
                                                                                <div class="py-6">
                                                                                    <input dusk="name" id="subTaskNotesInput" type="text" placeholder="Task Name" :value="t[0].data.name" onblur="document.getElementById('subTaskNotesHeader').style.display = 'block';document.getElementById('subTaskNotes').style.display = 'none';" @change="inlineSubTaskUpdate(index, 'name', $event)" class="w-full form-control form-input form-input-bordered">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div id="subTaskAssigneeHeader" v-if="t[0].data.assignee != null" onclick="this.style.display = 'none';document.getElementById('subTaskAssignee').style.display = 'block';document.getElementById('subTaskAssigneeInput').focus();">{{ t[0].data.assignee.name }}</div>
                                                                    <div v-else="" onclick="this.style.display = 'none';document.getElementById('subTaskAssignee').style.display = 'block';document.getElementById('subTaskAssigneeInput').focus();">None</div>
                                                                    <div class="remove-bottom-border" style="display: none" id="subTaskAssignee">
                                                                        <div class="flex">
                                                                            <div class="flex w-full">
                                                                                <div class="py-6">
                                                                                    <select onblur="document.getElementById('subTaskAssignee').style.display = 'none';document.getElementById('subTaskAssigneeHeader').style.display = 'block';" id="subTaskAssigneeInput" @change="inlineSubTaskUpdate(index, 'assignee', $event)" dusk="attachable-select" data-testid="workspace-select" name="assignee" class="form-control form-select mb-3 w-full">
                                                                                        <option value="" disabled>Choose Assigned To</option>
                                                                                        <option v-for="user in users" :value="user.gid" v-if="t[0].data.assignee != null && t[0].data.assignee.gid == user.gid" selected>{{ user.name }}</option>
                                                                                        <option :value="user.gid" v-else="">{{ user.name }}</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div :title="duedate(t[0].data.due_on)" id="subTaskDueOnHeader" onclick="this.style.display = 'none';document.getElementById('subTaskDueOn').style.display = 'block';">{{ t[0].data.due_on }}</div>
                                                                    <div class="remove-bottom-border" id="subTaskDueOn" style="display: none">
                                                                        <div class="flex">
                                                                            <div class="flex w-full">
                                                                                <div class="py-6">
                                                                                    <flat-pickr
                                                                                        :value="t[0].data.due_on"
                                                                                        @on-close="viewToggle"
                                                                                        @on-change="inlineSubTaskUpdate(index, 'due_on', $event)"
                                                                                        class="w-full form-control form-input-bordered"
                                                                                        placeholder="Select date"
                                                                                        autofocus="true"
                                                                                        name="due_on">
                                                                                    </flat-pickr>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-right">
                                                                    <span><a class="cursor-pointer text-70 hover:text-primary mr-3" dusk="13-view-button" title="View"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 16" aria-labelledby="view" role="presentation" class="fill-current"><path d="M16.56 13.66a8 8 0 0 1-11.32 0L.3 8.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95-.01.01zm-9.9-1.42a6 6 0 0 0 8.48 0L19.38 8l-4.24-4.24a6 6 0 0 0-8.48 0L2.4 8l4.25 4.24h.01zM10.9 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path></svg></a></span>
                                                                </td>
                                                            </tr>
                                                            <tr v-if="createNewSubTask">
                                                                <td>
                                                                    <div class="remove-bottom-border">
                                                                        <div class="flex">
                                                                            <div class="flex w-full">
                                                                                <input v-model="subTask.name" dusk="name" type="text" placeholder="Task Name" class="w-full form-control form-input form-input-bordered"> &lt;!&ndash;&ndash;&gt;
                                                                                <div class="help-text help-text mt-2" v-if="errors.name"><div class="text-danger">{{ errors.name[0] }}</div></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="remove-bottom-border">
                                                                        <div class="flex">
                                                                            <div class="flex w-full">
                                                                                <select v-model="subTask.assignee" dusk="attachable-select" data-testid="workspace-select" name="assignee" class="form-control form-select w-full">
                                                                                    <option value="" disabled="disabled">Choose Assigned To</option>
                                                                                    <option v-if="users.length > 0" v-for="user in users" :value="user.gid">{{ user.name }}</option>
                                                                                </select>
                                                                                <div class="help-text help-text mt-2" v-if="errors.assignee"><div class="text-danger">{{ errors.assignee[0] }}</div></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="remove-bottom-border">
                                                                        <div class="flex">
                                                                            <div class="flex w-full">
                                                                                <flat-pickr
                                                                                    v-model="subTask.due_on"
                                                                                    :config="config"
                                                                                    class="w-full form-control form-input-bordered"
                                                                                    placeholder="Select date"
                                                                                    name="date">
                                                                                </flat-pickr>
                                                                                <div class="help-text help-text mt-2" v-if="errors.due_on"><div class="text-danger">{{ errors.due_on[0] }}</div></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0)" @click="createSubTask(taskDetails[0].data.gid)" class="btn btn-default btn-primary" dusk="create-button">Create</a>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="flex" v-if="taskDetails.comments.data.length > 0">
                                                        <div class="w-full flex items-center">
                                                            <div class="pt-6 px-8">
                                                                <p class="py-1" v-for="comment in taskDetails.comments.data"><b>{{ comment.created_by.name }}</b> {{ comment.text }} <vue-moments-ago prefix="" suffix="ago" :date="comment.created_at"></vue-moments-ago></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex">
                                                        <div class="w-full flex items-center">
                                                            <div class="py-6 px-8" style="width: 100%">
                                                                <textarea @change="storeTaskComment(taskDetails[0].data.gid)" v-model="taskComment" dusk="title" rows="5" class="w-full form-control form-input form-input-bordered py-3 h-auto" placeholder="Ask a question or post an update"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
                <div v-if="projectDetails == null" class="card">
                    <h2 class="ph">No projects yet</h2>
                </div>
            </div>
            <div class="w-full" v-if="Template === 3">
                <div class="tabs-wrap border-b-2 border-40 w-full">
                    <div class="tabs flex flex-row overflow-x-auto">
                        <button class="py-5 px-8 border-b-2 focus:outline-none tab text-grey-black font-bold border-primary">
                            <div v-if="isEditTask">Update Task</div><div v-if="!isEditTask">Create Task</div>
                        </button>
                    </div>
                </div>
                <div class="tab-content tasks">

                    <div class="px-6 py-3">
                        <div class="flex border-b border-40 remove-bottom-border">
                            <div class="overflow-hidden overflow-x-auto relative w-full">

                                <div class="relative">
                                    <form autocomplete="off" @submit.prevent="storeTask">
                                        <div class="mb-8">
                                            <div class="card">
                                                <div class="remove-bottom-border">
                                                    <div class="flex border-b border-40">
                                                        <div class="flex border-b border-40 w-full">
                                                            <div class="w-1/5 py-6 px-8">
                                                                <label for="name" class="inline-block text-80 pt-2 leading-tight">Task Name</label>
                                                            </div>
                                                            <div class="py-6 px-8 w-1/2">
                                                                <input v-model="task.name" dusk="name" type="text" placeholder="Task Name" class="w-full form-control form-input form-input-bordered"> <!---->
                                                                <div class="help-text help-text mt-2" v-if="errors.name"><div class="text-danger">{{ errors.name[0] }}</div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="remove-bottom-border">
                                                    <div class="flex border-b border-40">
                                                        <div class="flex border-b border-40 w-full">
                                                            <div class="w-1/5 py-6 px-8">
                                                                <label for="name" class="inline-block text-80 pt-2 leading-tight">Assigned To</label>
                                                            </div>
                                                            <div class="py-6 px-8 w-1/2">
                                                                <select v-model="task.assignee" dusk="attachable-select" data-testid="workspace-select" name="assignee" class="form-control form-select mb-3 w-full">
                                                                    <option value="" disabled="disabled">Choose Assigned To</option>
                                                                    <option v-if="users.length > 0" v-for="user in users" :value="user.gid">{{ user.name }}</option>
                                                                </select>
                                                                <div class="help-text help-text mt-2" v-if="errors.assignee"><div class="text-danger">{{ errors.assignee[0] }}</div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="remove-bottom-border">
                                                    <div class="flex border-b border-40">
                                                        <div class="flex border-b border-40 w-full">
                                                            <div class="w-1/5 py-6 px-8">
                                                                <label for="name" class="inline-block text-80 pt-2 leading-tight">Type</label>
                                                            </div>
                                                            <div class="py-6 px-8 w-1/2">
                                                                <select v-model="task.section" dusk="attachable-select" data-testid="workspace-select" name="assignee" class="form-control form-select mb-3 w-full">
                                                                    <option value="" disabled="disabled">Choose Type</option>
                                                                    <option v-if="sections.length > 0" v-for="section in sections" :value="section.gid">{{ section.name }}</option>
                                                                </select>
                                                                <div class="help-text help-text mt-2" v-if="errors.section"><div class="text-danger">{{ errors.section[0] }}</div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="remove-bottom-border">
                                                    <div class="flex border-b border-40">
                                                        <div class="flex border-b border-40 w-full">
                                                            <div class="w-1/5 py-6 px-8">
                                                                <label for="name" class="inline-block text-80 pt-2 leading-tight">Due Date</label>
                                                            </div>
                                                            <div class="py-6 px-8 w-1/2">
                                                                <flat-pickr
                                                                    v-model="task.due_on"
                                                                    :config="config"
                                                                    class="w-full form-control form-input-bordered"
                                                                    placeholder="Select date"
                                                                    name="date">
                                                                </flat-pickr>
                                                                <div class="help-text help-text mt-2" v-if="errors.due_on"><div class="text-danger">{{ errors.due_on[0] }}</div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="remove-bottom-border">
                                                    <div class="flex border-b border-40">
                                                        <div class="flex border-b border-40 w-full">
                                                            <div class="w-1/5 py-6 px-8">
                                                                <label for="name" class="inline-block text-80 pt-2 leading-tight">Description</label>
                                                            </div>
                                                            <div class="py-6 px-8 w-1/2">
                                                                <textarea v-model="task.notes" dusk="title" rows="5" class="w-full form-control form-input form-input-bordered py-3 h-auto"></textarea>
                                                                <div class="help-text help-text mt-2" v-if="errors.notes"><div class="text-danger">{{ errors.notes[0] }}</div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <a tabindex="0" class="btn btn-link dim cursor-pointer text-80 ml-auto mr-6" @click="Template = 1">Cancel</a>
                                            <button v-if="!isEditTask" type="submit" class="btn btn-default btn-primary inline-flex items-center relative" dusk="create-button"><span class="">Create Task</span></button>
                                            <button v-if="isEditTask" type="submit" class="btn btn-default btn-primary inline-flex items-center relative" dusk="create-button"><span class="">Update Task</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
                createNewSubTask: false,
                createNewTaskCounter: 0,
                community: null,
                estForeclosures: 0,
                loaded: false,
                latestActivity: null,
                pendingChanges: 0,
                Template: 1,
                tasks: [],
                users: [],
                sections: [],
                sectionData: [],
                errors: [],
                success: null,
                projectDetails: null,
                isEditTask: false,
                isLoading: true,
                project: {
                    id: null,
                    name: null,
                    workspace: '25961259746709',
                    team: '1147285102599070',
                    osusr_mlv_community_id: this.resourceId,
                },
                task: {
                    id: null,
                    name: '',
                    workspace: '',
                    assignee: '',
                    due_on: '',
                    notes: '',
                    section: '',
                    project: [],
                },
                subTask: {
                    id: null,
                    name: '',
                    workspace: '25961259746709',
                    assignee: '',
                    due_on: '',
                    project: [],
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
                editStatus: 0,
                taskComment: '',
                taskDetailsTemplate: 1,
                isComplete: 0,
                isMarkComplete: 0,
                sideBar: 0,
                isTaskComplete: 0,
            }
        },
        computed: {
            communityName() {
                if (this.community) {
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
                this.project.name = null;
                document.getElementById('loader').style.display = 'block';
                Nova.request().get('/api/asana/project?osusr_mlv_community_id=' + this.resourceId).then(response => {
                    this.isLoading = false;
                    document.getElementById('loader').style.display = 'none';

                    if (response.data.data) {
                        this.projectDetails = response.data.data[0];
                        this.taskFilter.project = this.projectDetails.data.gid;
                        this.tasks = this.projectDetails.tasks;
                        this.sections = response.data.data['sections'].data;
                        this.sectionData = response.data.data['sectionData'];
                        this.users = response.data.data['users'].data;
                        this.task.project = this.projectDetails.data.gid;
                        this.subTask.project = this.projectDetails.data.gid;
                        this.task.workspace = this.projectDetails.data.workspace.gid;
                    } else {
                        this.projectDetails = null;
                    }

                    setTimeout(function () {
                        _this.uiUpdateMounted()
                    }, 500);
                });
            },
            createProject() {
                document.getElementById('loader').style.display = 'block';
                this.project.name = this.community.STATE + '-' + this.community.COUNTY + '-' + this.community.FRIENDLYNAME + '-' + this.community.COMMUNITYID + '-Standard';
                Nova.request().post('/api/asana/project/store', this.project).then(response => {
                    document.getElementById('loader').style.display = 'none';
                    if (response.data.status === 200) {
                        this.Template = 1;
                        this.getProjects();
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            createTask() {
                this.Template = 3;
                this.isEditTask = false;
                this.task.id = null;
                this.task.name = '';
                this.task.assignee = '';
                this.task.due_on = '';
                this.task.section = '';
                this.task.notes = '';
            },
            storeTask() {
                if (this.isEditTask) {
                    this.updateTask();
                } else {
                    document.getElementById('loader').style.display = 'block';
                    Nova.request().post('/api/asana/task/store', this.task).then(response => {
                        document.getElementById('loader').style.display = 'none';
                        if (response.data.status === 200) {
                            this.Template = 1;
                            this.getProjects();
                        } else {
                            this.errors = response.data.errors;
                        }
                    });
                }
            },
            showTask(id) {
                this.sideBar = 1;
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
            editTask(id) {
                this.Template = 3;
                this.isEditTask = true;
                document.getElementById('loader').style.display = 'block';
                Nova.request().get('/api/asana/task/' + id + '/edit').then(response => {
                    document.getElementById('loader').style.display = 'none';
                    this.task.id = id;
                    this.task.name = response.data.data.name ? response.data.data.name : '';
                    this.task.due_on = response.data.data.due_on ? response.data.data.due_on : '';
                    this.task.notes = response.data.data.notes ? response.data.data.notes : '';
                    this.task.assignee = response.data.data.assignee ? response.data.data.assignee.gid : '';
                    this.task.section = response.data.data.memberships[0].section.gid ? response.data.data.memberships[0].section.gid : '';
                    this.task.workspace = response.data.data.workspace.gid;
                });
            },
            updateTask() {
                this.task._method = "PUT";
                document.getElementById('loader').style.display = 'block';
                Nova.request().post('/api/asana/task/update/' + this.task.id, this.task).then(response => {
                    document.getElementById('loader').style.display = 'none';
                    if (response.data.status === 200) {
                        this.task = {};
                        this.Template = 1;
                        this.getProjects();
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            inlineTaskUpdate(index, name, e) {
                document.getElementById('loader').style.display = 'block';

                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('workspace', '25961259746709');

                if (name == 'completed') {
                    if (e.target.checked) {
                        formData.append(name, true);
                    } else {
                        formData.append(name, false);
                    }
                } else if (name == 'due_on') {
                    this.editThisQuick(index);
                    formData.append(name, this.convert(e));
                } else {
                    formData.append(name, e.target.value);
                }

                if (name == 'name') {
                    this.tasks[index].data.name = e.target.value;
                } else if(name == 'notes') {
                    this.tasks[index].data.notes = e.target.value;
                } else if(name == 'due_on') {
                    this.tasks[index].data.due_on = this.convert(e);
                } else if (name == 'section') {
                    this.tasks[index].data.memberships[0].section.gid = e.target.value;
                    this.tasks[index].data.memberships[0].section.name = e.target.options[e.target.selectedIndex].text;
                }  else if (name == 'assignee') {
                    this.tasks[index].data.assignee.gid = e.target.value;
                    this.tasks[index].data.assignee.name = e.target.options[e.target.selectedIndex].text;
                }

                let t = this.tasks[index];

                Nova.request().post('/api/asana/task/update/' + t.data.gid, formData).then(response => {
                    document.getElementById('loader').style.display = 'none';
                    if (response.data.status === 200) {
                        this.Template = 1;
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            inlineTaskUpdateNew(id, name, e) {
                document.getElementById('loader').style.display = 'block';

                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('workspace', '25961259746709');

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
                } else {
                    formData.append(name, e.target.value);
                }

                Nova.request().post('/api/asana/task/update/' + id, formData).then(response => {
                    document.getElementById('loader').style.display = 'none';
                    if (response.data.status === 200) {
                        this.Template = 1;
                        if (name == 'name') {
                            this.taskDetails[0].data.name = e.target.value;
                        } else if(name == 'notes') {
                            this.taskDetails[0].data.notes = e.target.value;
                        } else if(name == 'due_on') {
                            document.getElementById('taskDueOnHeader').style.display = 'block';
                            document.getElementById('taskDueOn').style.display = 'none';
                            this.taskDetails[0].data.due_on = this.convert(e);
                        } else if (name == 'section') {
                            this.taskDetails[0].data.memberships[0].section.gid = e.target.value;
                            this.taskDetails[0].data.memberships[0].section.name = e.target.options[e.target.selectedIndex].text;
                        }  else if (name == 'assignee') {
                            document.getElementById('taskAssigneeHeader').style.display = 'block';
                            document.getElementById('taskAssignee').style.display = 'none';
                            this.taskDetails[0].data.assignee.gid = e.target.value;
                            this.taskDetails[0].data.assignee.name = e.target.options[e.target.selectedIndex].text;
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
                        document.getElementById('taskDetails').style.display = 'none';
                        document.getElementById('loader').style.display = 'block';

                        Nova.request().post('/api/asana/task/destroy/' + id, {_method: 'DELETE'}).then(response => {
                            if (response.data.status === 200) {
                                THIS.Template = 1;
                                THIS.getProjects();
                                document.getElementById('loader').style.display = 'none';
                            } else {
                                THIS.errors = response.data.errors;
                            }
                        });
                    }
                });
            },
            filterTasks(a, b, c) {
                let THIS = this;
                this.taskFilter.due_on = b;
                document.getElementById('loader').style.display = 'block';
                let params = new URLSearchParams(THIS.taskFilter);
                params = params.toString();
                Nova.request().get('/api/asana/task/show?' + params).then(response => {
                    if (response.data.status === 200) {
                        THIS.Template = 1;
                        THIS.tasks = response.data.data;
                        document.getElementById('loader').style.display = 'none';
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
                document.getElementById('loader').style.display = 'block';
                Nova.request().post('/api/asana/task/' + id + '/subtasks', this.subTask).then(response => {
                    document.getElementById('loader').style.display = 'none';
                    if (response.data.status === 200) {
                        this.createNewSubTask = false;
                        this.taskDetails.subTasks.push(response.data.data);
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            viewToggle() {
                document.getElementById('taskDueOnHeader').style.display = 'block';
                document.getElementById('taskDueOn').style.display = 'none';

                document.getElementById('subTaskDueOnHeader').style.display = 'block';
                document.getElementById('subTaskDueOn').style.display = 'none';
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
            inlineSubTaskUpdate(index, name, e) {
                document.getElementById('loader').style.display = 'block';

                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('workspace', '25961259746709');

                if (name == 'completed') {
                    if (e.target.checked) {
                        formData.append(name, true);
                        this.taskDetails.subTasks[index].data.completed = true;
                    } else {
                        formData.append(name, false);
                        this.taskDetails.subTasks[index].data.completed = false;
                    }
                } else if (name == 'due_on') {
                    formData.append(name, this.convert(e));
                } else {
                    formData.append(name, e.target.value);
                }

                if (name == 'name') {
                    this.taskDetails.subTasks[index].data.name = e.target.value;
                } else if(name == 'notes') {
                    this.taskDetails.subTasks[index].data.notes = e.target.value;
                } else if(name == 'due_on') {
                    this.taskDetails.subTasks[index].data.due_on = this.convert(e);

                    document.getElementById('subTaskDueOnHeader').style.display = 'block';
                    document.getElementById('subTaskDueOn').style.display = 'none';
                } else if (name == 'section') {
                    this.taskDetails.subTasks[index].data.memberships[0].section.gid = e.target.value;
                    this.taskDetails.subTasks[index].data.memberships[0].section.name = e.target.options[e.target.selectedIndex].text;
                }  else if (name == 'assignee') {
                    document.getElementById('subTaskAssignee').style.display = 'none';
                    document.getElementById('subTaskAssigneeHeader').style.display = 'block';

                    this.taskDetails.subTasks[index].data.assignee.gid = e.target.value;
                    this.taskDetails.subTasks[index].data.assignee.name = e.target.options[e.target.selectedIndex].text;
                }

                let t = this.taskDetails.subTasks[index];

                Nova.request().post('/api/asana/task/update/' + t.data.gid, formData).then(response => {
                    document.getElementById('loader').style.display = 'none';
                    if (response.data.status === 200) {
                        this.Template = 1;
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
            focusInput(e){
                //$(e.target).find("input").focus();
            },
            uiUpdateMounted: function () {
                let _this = this;

                $('.main-wrapper').on('click','.nv-collapse', function () {
                    $(this).closest('.collapse-parent').find('.nv-collapsedown').slideToggle();
                });

                $('.main-wrapper').on('click','.nv-dropdown', function () {
                    $('.nv-dropdown').removeClass('nv-open');
                    $(this).addClass('nv-open');
                });

                $(window).on('mouseup', function(e){
                    var clicked = $(e.target);
                    var clickTarget = clicked.closest('.nv-dropdown');
                    if(clickTarget.length === 0){
                        $('.nv-dropdown').removeClass('nv-open');
                    }
                    var sideBar = clicked.closest('#task-detail');
                    if(sideBar.length === 0){
                        _this.sideBar = 0;
                    }
                    $("#assignee-logo-id").removeClass("logo-hide");
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
        },
        mounted() {
            this.getProjects();
        }
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

    #loader {
        display: none;
    }

    .lds-facebook {
        display: inline-block;
        position: relative;
        width: 64px;
        height: 64px;
    }
    .lds-facebook div {
        display: inline-block;
        position: absolute;
        left: 6px;
        width: 13px;
        background: #fff;
        animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
    }
    .lds-facebook div:nth-child(1) {
        left: 6px;
        animation-delay: -0.24s;
    }
    .lds-facebook div:nth-child(2) {
        left: 26px;
        animation-delay: -0.12s;
    }
    .lds-facebook div:nth-child(3) {
        left: 45px;
        /*animation-delay: 0;*/
    }
    .ph{
        padding: 20px 10px;
    }
    @keyframes lds-facebook {
        0% {
            top: 6px;
            height: 51px;
        }
        50%, 100% {
            top: 19px;
            height: 26px;
        }
    }
</style>
