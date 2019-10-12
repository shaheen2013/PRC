<template>
    <loading-card :loading="!loaded">
        <card class="flex flex-col items-center justify-center">
            <div class="px-3 py-3">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Partner Status</th>
                        <th scope="col" colspan="2">Rental</th>
                        <th scope="col" colspan="2">Vacant</th>
                        <th scope="col" colspan="2">Forclosure</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row"></th>
                        <th>CMs</th>
                        <th>OTRs</th>
                        <th>CMs</th>
                        <th>OTRs</th>
                        <th>CMs</th>
                        <th>OTRs</th>
                    </tr>
                    <tr>
                        <th scope="row">No Activity</th>
                        <td>
                            <router-link @click="$emit('filter-changed')" :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6dHJ1ZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{rental.cms.noActivity | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link @click="$emit('filter-changed')" :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6dHJ1ZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{rental.otrs.noActivity | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU3RhdHVzIiwidmFsdWUiOiI3In0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5UXVhcnRpbGUiLCJ2YWx1ZSI6IiJ9XQ%3D%3D'">
                                {{vacant.cms.noActivity | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU3RhdHVzIiwidmFsdWUiOiI3In0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5UXVhcnRpbGUiLCJ2YWx1ZSI6IiJ9XQ%3D%3D'">
                                {{vacant.otrs.noActivity | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU3RhdHVzIiwidmFsdWUiOiI3In0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5UXVhcnRpbGUiLCJ2YWx1ZSI6IiJ9XQ%3D%3D'">
                                {{foreclosure.cms.noActivity | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU3RhdHVzIiwidmFsdWUiOiI3In0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5UXVhcnRpbGUiLCJ2YWx1ZSI6IiJ9XQ%3D%3D'">
                                {{foreclosure.otrs.noActivity | addCommas}}
                            </router-link>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Generate</th>
                        <td @click="filterChanged">
                            <router-link @click="filterChanged" :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6dHJ1ZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{rental.cms.generate | addCommas}}
                            </router-link>
                        </td>
                        <td @click="filterChanged">
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6dHJ1ZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{rental.otrs.generate | addCommas}}
                            </router-link>
                        </td>
                        <td @click="changeFilter">
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3Ijp0cnVlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{vacant.cms.generate | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3Ijp0cnVlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{vacant.otrs.generate | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlGb3JlY2xvc3VyZVNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOnRydWUsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{foreclosure.cms.generate | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlGb3JlY2xvc3VyZVNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOnRydWUsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{foreclosure.otrs.generate | addCommas}}
                            </router-link>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Guide</th>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjp0cnVlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{rental.cms.guide | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjp0cnVlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{rental.otrs.guide | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOnRydWUsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{vacant.cms.guide | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOnRydWUsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{vacant.otrs.guide | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlGb3JlY2xvc3VyZVNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjp0cnVlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{foreclosure.cms.guide | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlGb3JlY2xvc3VyZVNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjp0cnVlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{foreclosure.otrs.guide | addCommas}}
                            </router-link>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Propose</th>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOnRydWV9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{rental.cms.propose | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOnRydWV9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{rental.otrs.propose | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6dHJ1ZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{vacant.cms.propose | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6dHJ1ZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{vacant.otrs.propose | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlGb3JlY2xvc3VyZVNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOnRydWV9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{foreclosure.cms.propose | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlGb3JlY2xvc3VyZVNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOnRydWV9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{foreclosure.otrs.propose | addCommas}}
                            </router-link>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Onboard</th>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2Ijp0cnVlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{rental.cms.onboard | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2Ijp0cnVlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{rental.otrs.onboard | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOnRydWUsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{vacant.cms.onboard | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOnRydWUsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{vacant.otrs.onboard | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlGb3JlY2xvc3VyZVNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2Ijp0cnVlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{foreclosure.cms.onboard | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlGb3JlY2xvc3VyZVNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2Ijp0cnVlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{foreclosure.otrs.onboard | addCommas}}
                            </router-link>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Enhance & Renew</th>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOnRydWUsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{rental.cms.enhance | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOnRydWUsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlWYWNhbnRTYWxlc1N0YXR1cyIsInZhbHVlIjp7IjEiOmZhbHNlLCI1IjpmYWxzZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'"
                                         @click="$emit('filter-changed')"
                            >
                                {{rental.otrs.enhance | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6dHJ1ZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{vacant.cms.enhance | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6dHJ1ZSwiNiI6ZmFsc2UsIjciOmZhbHNlLCIxMSI6ZmFsc2UsIjEyIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eUZvcmVjbG9zdXJlU2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'"
                                         @click="$emit('filter-changed')"
                            >
                                {{vacant.otrs.enhance | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlGb3JlY2xvc3VyZVNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOnRydWUsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'">
                                {{foreclosure.cms.enhance | addCommas}}
                            </router-link>
                        </td>
                        <td>
                            <router-link :to="'/resources/c-m-communities?c-m-communities_page=1&c-m-communities_filter=W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVNpemUiLCJ2YWx1ZSI6eyIwIjpmYWxzZSwiMSI6ZmFsc2UsIjIiOmZhbHNlLCIzIjpmYWxzZX19LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXENvbW11bml0eVJlbnRhbFNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOmZhbHNlLCI2IjpmYWxzZSwiNyI6ZmFsc2UsIjExIjpmYWxzZSwiMTIiOmZhbHNlfX0seyJjbGFzcyI6IkFwcFxcTm92YVxcRmlsdGVyc1xcQ29tbXVuaXR5VmFjYW50U2FsZXNTdGF0dXMiLCJ2YWx1ZSI6eyIxIjpmYWxzZSwiNSI6ZmFsc2UsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlGb3JlY2xvc3VyZVNhbGVzU3RhdHVzIiwidmFsdWUiOnsiMSI6ZmFsc2UsIjUiOnRydWUsIjYiOmZhbHNlLCI3IjpmYWxzZSwiMTEiOmZhbHNlLCIxMiI6ZmFsc2V9fSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxSZWxhdGlvbnNoaXBNYW5hZ2VyIiwidmFsdWUiOiIifSx7ImNsYXNzIjoiQXBwXFxOb3ZhXFxGaWx0ZXJzXFxDb21tdW5pdHlTdGF0ZSIsInZhbHVlIjoiIn1d'"
                                            @click="$emit('filter-changed')"
                            >
                                {{foreclosure.otrs.enhance | addCommas}}
                            </router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </card>
    </loading-card>
</template>

<script>
    import {
        Filterable,
        InteractsWithQueryString
    } from 'laravel-nova'
export default {
    mixins: [
        Filterable,
        InteractsWithQueryString,
    ],
    props: [
        'card',
    ],
    filters: {
        addCommas: function (value) {
                var parts = value.toString().split(".");
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return parts.join(".");
        }
    },
    data: () => ({
        loading: false,
        baseUrl: "http://cm.local:8000/admin",
        rental: {
            cms: {
                noActivity: "",
                generate: "",
                guide: "",
                propose: "",
                onboard: "",
                enhance: ""
            },
            otrs: {
                noActivity: "",
                generate: "",
                guide: "",
                propose: "",
                onboard: "",
                enhance: ""
            }
        },
        foreclosure: {
            cms: {
                noActivity: "",
                generate: "",
                guide: "",
                propose: "",
                onboard: "",
                enhance: ""
            },
            otrs: {
                noActivity: "",
                generate: "",
                guide: "",
                propose: "",
                onboard: "",
                enhance: ""
            }
        },
        vacant: {
            cms: {
                noActivity: "",
                generate: "",
                guide: "",
                propose: "",
                onboard: "",
                enhance: ""
            },
            otrs: {
                noActivity: "",
                generate: "",
                guide: "",
                propose: "",
                onboard: "",
                enhance: ""
            }
        },
        loadedCount: 0
    }),
    computed: {
        loaded: function () {
            return this.loadedCount === 18;
        },
    },
    methods: {
        changeFilter() {
            this.updateQueryString({
                [this.pageParameter]: 1,
                [this.filterParameter]: this.$store.getters[`${this.resourceName}/currentEncodedFilters`],
            })
        }
    },
    mounted() {

        Nova.request().get('/nova-vendor/CommunityStatusTable/foreclosureEnhance').then(response => {
            this.foreclosure.cms.enhance = response.data.cms;
            this.foreclosure.otrs.enhance = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/foreclosureGenerate').then(response => {
            this.foreclosure.cms.generate = response.data.cms;
            this.foreclosure.otrs.generate = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/foreclosureGuide').then(response => {
            this.foreclosure.cms.guide = response.data.cms;
            this.foreclosure.otrs.guide = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/foreclosurePropose').then(response => {
            this.foreclosure.cms.propose = response.data.cms;
            this.foreclosure.otrs.propose = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/foreclosureOnboard').then(response => {
            this.foreclosure.cms.onboard = response.data.cms;
            this.foreclosure.otrs.onboard = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/foreclosureNoActivity').then(response => {
            this.foreclosure.cms.noActivity = response.data.cms;
            this.foreclosure.otrs.noActivity = response.data.otrs;
            this.loadedCount++;
        });


//////////////////////////////////////////Rental//////////////////////////////////////////////////////////////////////////////////

        Nova.request().get('/nova-vendor/CommunityStatusTable/rentalEnhance').then(response => {
            this.rental.cms.enhance = response.data.cms;
            this.rental.otrs.enhance = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/rentalGenerate').then(response => {
            this.rental.cms.generate = response.data.cms;
            this.rental.otrs.generate = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/rentalGuide').then(response => {
            this.rental.cms.guide = response.data.cms;
            this.rental.otrs.guide = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/rentalPropose').then(response => {
            this.rental.cms.propose = response.data.cms;
            this.rental.otrs.propose = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/rentalOnboard').then(response => {
            this.rental.cms.onboard = response.data.cms;
            this.rental.otrs.onboard = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/rentalNoActivity').then(response => {
            this.rental.cms.noActivity = response.data.cms;
            this.rental.otrs.noActivity = response.data.otrs;
            this.loadedCount++;
        });

/////////////////////////////////////////////Vacant////////////////////////////////////////////////////////////////

        Nova.request().get('/nova-vendor/CommunityStatusTable/vacantEnhance').then(response => {
            this.vacant.cms.enhance = response.data.cms;
            this.vacant.otrs.enhance = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/vacantGenerate').then(response => {
            this.vacant.cms.generate = response.data.cms;
            this.vacant.otrs.generate = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/vacantGuide').then(response => {
            this.vacant.cms.guide = response.data.cms;
            this.vacant.otrs.guide = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/vacantPropose').then(response => {
            this.vacant.cms.propose = response.data.cms;
            this.vacant.otrs.propose = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/vacantOnboard').then(response => {
            this.vacant.cms.onboard = response.data.cms;
            this.vacant.otrs.onboard = response.data.otrs;
            this.loadedCount++;
        });
        Nova.request().get('/nova-vendor/CommunityStatusTable/vacantNoActivity').then(response => {
            this.vacant.cms.noActivity = response.data.cms;
            this.vacant.otrs.noActivity = response.data.otrs;
            this.loadedCount++;
        });
    },
}
</script>

<style scoped>
    a:hover, a:visited, a:link, a:active
    {
        text-decoration: none;
        color: #2176bd;
    }

    td
    {
        font-weight: 800;
        text-align: center;
    }

</style>