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
        <div class="flex" style="">
            <!---->
            <div class="w-full flex items-center">
                <h1 class="flex-no-shrink text-90 font-normal text-2xl">Tasks/Projects</h1>
                <!---->
                <div class="flex-no-shrink ml-auto mb-6">
                    <a href="javascript:void(0)" v-if="projectDetails == null" @click="Template=2, isEditProject=false" class="btn btn-default btn-primary" dusk="create-button">Create Project</a>
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

                                <!--<a @click="editProject(projectDetails.data.gid)" class="cursor-pointer text-70 hover:text-primary mr-1" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                         viewBox="0 0 20 20" aria-labelledby="edit" role="presentation"
                                         class="fill-current">
                                        <path
                                            d="M4.3 10.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H5a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM6 14h2.59l9-9L15 2.41l-9 9V14zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2h6a1 1 0 1 1 0 2H2v14h14v-6z"></path>
                                    </svg>
                                </a>
                                <a title="Delete" @click="deleteProject(projectDetails.data.gid)" class="cursor-pointer text-70 hover:text-danger mr-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                         viewBox="0 0 20 20" aria-labelledby="delete" role="presentation"
                                         class="fill-current">
                                        <path fill-rule="nonzero"
                                              d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"></path>
                                    </svg>
                                </a>-->

                            </button>
                        </div>
                    </div>
                    <div v-if="projectDetails" class="tab-content" :class="projectDetails.data.name">
                        <div class="px-6 py-3">
                            <div class="flex border-b border-40 remove-bottom-border">
                                <div class="overflow-hidden overflow-x-auto relative w-full">
                                    <table class="table w-full">
                                        <thead>
                                        <tr>
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
                                    <table class="table w-full">
                                        <thead>
                                        <tr>
                                            <th class="text-left">SL</th>
                                            <th class="text-left">Task</th>
                                            <th class="text-left">Type</th>
                                            <th class="text-left">Due Date</th>
                                            <th class="text-left">Description</th>
                                            <th class="text-left">Complete</th>
                                            <th class="text-right">
                                                <div class="flex-no-shrink ml-auto mb-6">
                                                    <a href="javascript:void(0)" @click="createTask" class="btn btn-default btn-primary" dusk="create-button">Create Task</a>
                                                </div>
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
                                            </td>
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
                                            <td>
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
                                            </td>
                                            <td class="text-right">
                                                <input type="file" id="file" name="file" v-on:change="handleFileUpload(t.data.gid, $event)" style="display: none">
                                                <a onclick="document.getElementById('file').click()" class="cursor-pointer text-70 hover:text-primary mr-3" dusk="13-view-button" title="Attach file"><i class="fa fa-paperclip"></i></a>
                                                <span><a @click="showTask(t.data.gid)" class="cursor-pointer text-70 hover:text-primary mr-3" dusk="13-view-button" title="View"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 16" aria-labelledby="view" role="presentation" class="fill-current"><path d="M16.56 13.66a8 8 0 0 1-11.32 0L.3 8.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95-.01.01zm-9.9-1.42a6 6 0 0 0 8.48 0L19.38 8l-4.24-4.24a6 6 0 0 0-8.48 0L2.4 8l4.25 4.24h.01zM10.9 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path></svg></a></span>
                                                <a @click="editTask(t.data.gid)" class="cursor-pointer text-70 hover:text-primary mr-3" dusk="1-edit-button"
                                                   title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         viewBox="0 0 20 20" aria-labelledby="edit" role="presentation"
                                                         class="fill-current">
                                                        <path
                                                            d="M4.3 10.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H5a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM6 14h2.59l9-9L15 2.41l-9 9V14zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2h6a1 1 0 1 1 0 2H2v14h14v-6z"></path>
                                                    </svg>
                                                </a>
                                                <a title="Delete" @click="deleteTask(t.data.gid)"
                                                   class="appearance-none cursor-pointer text-70 hover:text-danger mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         viewBox="0 0 20 20" aria-labelledby="delete" role="presentation"
                                                         class="fill-current">
                                                        <path fill-rule="nonzero"
                                                              d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="projectDetails == null" class="card">
                    <h2 class="ph">No projects yet</h2>
                </div>
            </div>
            <div class="w-full" v-if="Template === 2">
                <div class="tabs-wrap border-b-2 border-40 w-full">
                    <div class="tabs flex flex-row overflow-x-auto">
                        <button class="py-5 px-8 border-b-2 focus:outline-none tab text-grey-black font-bold border-primary">
                            <div v-if="isEditProject">Update Project</div><div v-if="!isEditProject">Create Project</div>
                        </button>
                    </div>
                </div>
                <div class="tab-content tasks">

                    <div class="px-6 py-3">
                        <div class="flex border-b border-40 remove-bottom-border">
                            <div class="overflow-hidden overflow-x-auto relative w-full">

                                <div class="relative">
                                    <form autocomplete="off" @submit.prevent="createProject">
                                        <div class="mb-8">
                                            <div class="card">
                                                <div class="remove-bottom-border">
                                                    <div class="flex border-b border-40">
                                                        <div class="flex border-b border-40 w-full">
                                                            <div class="w-1/5 py-6 px-8">
                                                                <label for="name" class="inline-block text-80 pt-2 leading-tight">Project Name</label>
                                                            </div>
                                                            <div class="py-6 px-8 w-1/2">
                                                                <input id="name" v-model="project.name" dusk="name" type="text" placeholder="Project Name" class="w-full form-control form-input form-input-bordered"> <!---->
                                                                <div class="help-text help-text mt-2" v-if="errors.name"><div class="text-danger">{{ errors.name[0] }}</div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <a tabindex="0" class="btn btn-link dim cursor-pointer text-80 ml-auto mr-6" @click="Template = 1">Cancel</a>
                                            <button v-if="!isEditProject" type="submit" class="btn btn-default btn-primary inline-flex items-center relative" dusk="create-button"><span class="">Create Project</span></button>
                                            <button v-if="isEditProject" type="submit" class="btn btn-default btn-primary inline-flex items-center relative" dusk="create-button"><span class="">Update Project</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <div class="w-full" v-if="Template === 4 && taskDetails">
                <div class="tabs-wrap border-b-2 border-40 w-full">
                    <div class="tabs flex flex-row overflow-x-auto">
                        <button class="py-5 px-8 border-b-2 focus:outline-none tab text-grey-black font-bold border-primary">
                            {{ taskDetails[0].data.name }}
                        </button>
                    </div>
                </div>
                <div class="tab-content tasks">
                    <div class="px-6 py-3">
                        <div class="flex border-b border-40 remove-bottom-border">
                            <div class="overflow-hidden overflow-x-auto relative w-full">
                                <div class="flex" style="">
                                    <!---->
                                    <div class="w-full flex items-center">
                                        <h3 class="flex-no-shrink text-90 font-normal text-2xl">Subtaks</h3>
                                        <!---->
                                        <div class="flex-no-shrink ml-auto mb-6">
                                            <a href="javascript:void(0)" @click="Template = 1" class="btn btn-default btn-primary" dusk="create-button">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <table class="table w-full">
                                    <thead>
                                    <tr>
                                        <th class="text-left">SL</th>
                                        <th class="text-left">Task</th>
                                        <th class="text-left">Type</th>
                                        <th class="text-left">Due Date</th>
                                        <th class="text-left">Description</th>
                                        <th class="text-left">Complete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-if="taskDetails.subTasks.length > 0" v-for="(t,index) in taskDetails.subTasks">
                                        <td v-text="index+1"></td>
                                        <td>{{ t.data.name }}</td>
                                        <td v-if="t.data.memberships.length > 0">{{ t.data.memberships[0].section.name }}</td>
                                        <td v-else=""></td>
                                        <td>{{ t.data.due_on }}</td>
                                        <td>{{ t.data.notes }}</td>
                                        <td>
                                            <input type="checkbox" v-if="t.data.completed" checked disabled>
                                            <input type="checkbox" v-else="" disabled>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
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
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import {VTooltip, VPopover, VClosePopover} from 'v-tooltip'

    export default {
        directives: {
            tooltip: VTooltip,
            'v-popover': VClosePopover,
        },
        components: {
            'v-popover': VPopover,
            flatPickr
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
                showMe: 1,
                community: null,
                estForeclosures: 0,
                loaded: false,
                latestActivity: null,
                pendingChanges: 0,
                projects: [],
                Template: 1,
                workspaces: [],
                teams: [],
                tasks: [],
                users: [],
                sections: [],
                workspaceProjects: [],
                errors: [],
                success: null,
                isEditProject: false,
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
            editThisQuick(ind){
                let THIS = this;
                this.showMe = 0;
                if(this.tasks[ind].editStatus == undefined || this.tasks[ind].editStatus == 0){
                    this.tasks[ind].editStatus = 1;
                } else {
                    this.tasks[ind].editStatus = 0;
                }

                setTimeout(function () {
                    THIS.showMe = 1;
                }, 500)
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
                this.project.name = null;
                document.getElementById('loader').style.display = 'block';
                Nova.request().get('/api/asana/project?osusr_mlv_community_id=' + this.resourceId).then(response => {
                    this.isLoading = false;
                    document.getElementById('loader').style.display = 'none';
                    if (response.data.data.length > 0) {
                        this.projects = response.data.data;
                        this.projectDetails = this.projects[0];
                        this.taskFilter.project = this.projectDetails.data.gid;
                        this.tasks = this.projectDetails.tasks;
                        this.sections = this.projects[0].sections.data;
                        this.users = this.projects[0].users.data;
                        this.task.project = this.projectDetails.data.gid;
                        this.task.workspace = this.projectDetails.data.workspace.gid;
                    } else {
                        this.projectDetails = null;
                    }
                });
            },
            getWorkspaces() {
                document.getElementById('loader').style.display = 'block';
                Nova.request().get('/api/asana/project/create').then(response => {
                    document.getElementById('loader').style.display = 'none';
                    this.workspaces = response.data.data.data;
                });
            },
            getTeams() {
                this.teams = this.workspaces.find(workspace => {return workspace.gid == document.getElementById('workspace').value}).teams.data;
            },
            createProject() {
                document.getElementById('loader').style.display = 'block';
                this.project.name = this.community.STATE + '-' + this.community.COUNTY + '-' + this.project.name + '-' + this.community.COMMUNITYID + '-Standard';
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
            /*editProject(id) {
                this.Template = 2;
                this.isEditProject = true;
                document.getElementById('loader').style.display = 'block';
                Nova.request().get('/api/asana/project/' + id + '/edit').then(response => {
                    document.getElementById('loader').style.display = 'none';
                    this.project.id = id;
                    this.project.name = response.data.data.name;
                    this.project.workspace = response.data.data.workspace.gid;
                });
            },
            updateProject() {
                this.project._method = "PUT";
                document.getElementById('loader').style.display = 'block';
                Nova.request().post('/api/asana/project/update/' + this.project.id, this.project).then(response => {
                    document.getElementById('loader').style.display = 'none';
                    if (response.data.status === 200) {
                        this.Template = 1;
                        this.getProjects();
                    } else {
                        this.errors = response.data.errors;
                    }
                });
            },
            deleteProject(id) {
                let THIS = this;
                Swal.fire({
                    type: 'error',
                    title: 'Delete Project',
                    text: 'Are you sure want to delete this data?',
                    showCancelButton: true,
                    focusConfirm: true
                }).then(res => {
                    if(res.value !== undefined){
                        document.getElementById('loader').style.display = 'block';
                        Nova.request().post('/api/asana/project/destroy/' + id, {_method: 'DELETE'}).then(response => {
                            document.getElementById('loader').style.display = 'none';
                            if (response.data.status === 200) {
                                THIS.Template = 1;
                                THIS.getProjects();
                            } else {
                                THIS.errors = response.data.errors;
                            }
                        });
                    }
                });
            },*/
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
            getWorkspaceProjects() {
                if (!this.isEditTask) {
                    this.workspaceProjects = this.workspaces.find(workspace => {return workspace.gid == document.getElementById('task-workspace').value}).projects.data;
                    this.users = this.workspaces.find(workspace => {return workspace.gid == document.getElementById('task-workspace').value}).users.data;
                }
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
                this.Template = 4;
                this.isEditTask = true;
                document.getElementById('loader').style.display = 'block';
                Nova.request().get('/api/asana/task/details/' + id).then(response => {
                    document.getElementById('loader').style.display = 'none';
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
                }

                let t = this.tasks[index];

                document.getElementById('loader').style.display = 'block';

                Nova.request().post('/api/asana/task/update/' + t.data.gid, formData).then(response => {
                    document.getElementById('loader').style.display = 'none';
                    if (response.data.status === 200) {
                        this.Template = 1;
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
            this.getWorkspaces();
        }
    }
</script>

<style scoped>
    @import "../../static/css/main.css";

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
