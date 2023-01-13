<div>
    <main>
        <!-- Page header -->
        <div class="mx-auto max-w-3xl px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
            <div class="flex items-center space-x-5">
{{--                    <div class="flex-shrink-0">--}}
{{--                        <div class="relative">--}}
{{--                            <img class="h-16 w-16 rounded-full" src="https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80" alt="">--}}
{{--                            <span class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $part->firstname }} {{ $part->lastname }} {{ $part->company ? ' - ' . $part->company : '' }}</h1>
                    <p class="text-sm font-medium text-gray-500">Applied for <a href="#" class="text-gray-900">Front End Developer</a> on <time datetime="2020-08-25">August 25, 2020</time></p>
                </div>
            </div>
            <div class="justify-stretch mt-6 flex flex-col-reverse space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-y-0 sm:space-x-3 sm:space-x-reverse md:mt-0 md:flex-row md:space-x-3">
                <button type="button" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-100">Disqualify</button>
                <button type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-100">Advance to offer</button>
            </div>
        </div>

        <div class="mx-auto mt-8 grid max-w-3xl grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2 lg:col-start-1">
                <!-- Participant -->
                <section aria-labelledby="applicant-information-title">
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h2 id="applicant-information-title" class="text-lg font-medium leading-6 text-gray-900">
                                {{ _i('participant') }}</h2>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application.</p>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ _i('address') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $part->street ? $part->street . ', ' . $part->zipcode . ' ' . $part->location : '' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ _i('payment') }}</dt>
                                    <dd class="mt-1 text-sm {{ $part->payed ? 'text-green-800' : 'text-red-800' }}">
                                        @can('update', $part)
                                            <x-button.link wire:click="pay()">{{ $part->price_gross }} {{ $part->currency }} - {{ __('payments.' . $part->payment . '.title') }}</x-button.link>
                                        @else
                                            <x-button.link disabled>{{ $part->price_gross }} {{ $part->currency }} - {{ __('payments.' . $part->payment . '.title') }}</x-button.link>
                                        @endif
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ _i('e-mail address') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $part->email }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ _i('phone') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $part->phone }}</dd>
                                </div>
{{--                                    <div class="sm:col-span-2">--}}
{{--                                        <dt class="text-sm font-medium text-gray-500">About</dt>--}}
{{--                                        <dd class="mt-1 text-sm text-gray-900">Fugiat ipsum ipsum deserunt culpa aute sint do nostrud anim incididunt cillum culpa consequat. Excepteur qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud in ea officia proident. Irure nostrud pariatur mollit ad adipisicing reprehenderit deserunt qui eu.</dd>--}}
{{--                                    </div>--}}
{{--                                    <div class="sm:col-span-2">--}}
{{--                                        <dt class="text-sm font-medium text-gray-500">Attachments</dt>--}}
{{--                                        <dd class="mt-1 text-sm text-gray-900">--}}
{{--                                            <ul role="list" class="divide-y divide-gray-200 rounded-md border border-gray-200">--}}
{{--                                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">--}}
{{--                                                    <div class="flex w-0 flex-1 items-center">--}}
{{--                                                        <!-- Heroicon name: mini/paper-clip -->--}}
{{--                                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
{{--                                                            <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />--}}
{{--                                                        </svg>--}}
{{--                                                        <span class="ml-2 w-0 flex-1 truncate">resume_front_end_developer.pdf</span>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="ml-4 flex-shrink-0">--}}
{{--                                                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Download</a>--}}
{{--                                                    </div>--}}
{{--                                                </li>--}}

{{--                                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">--}}
{{--                                                    <div class="flex w-0 flex-1 items-center">--}}
{{--                                                        <!-- Heroicon name: mini/paper-clip -->--}}
{{--                                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
{{--                                                            <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />--}}
{{--                                                        </svg>--}}
{{--                                                        <span class="ml-2 w-0 flex-1 truncate">coverletter_front_end_developer.pdf</span>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="ml-4 flex-shrink-0">--}}
{{--                                                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Download</a>--}}
{{--                                                    </div>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </dd>--}}
{{--                                    </div>--}}
                            </dl>
                        </div>
{{--                            <div>--}}
{{--                                <a href="#" class="block bg-gray-50 px-4 py-4 text-center text-sm font-medium text-gray-500 hover:text-gray-700 sm:rounded-b-lg">Read full application</a>--}}
{{--                            </div>--}}
                    </div>
                </section>

                <!-- Contact Person -->
                @if($part->contact_id)
                    <section aria-labelledby="applicant-information-title">
                        <div class="bg-white shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6">
                                <h2 id="applicant-information-title" class="text-lg font-medium leading-6 text-gray-900">
                                    {{ _i('contact person') }}</h2>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application.</p>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">{{ _i('company') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $part->contactPerson->company }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">{{ _i('name') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $part->contactPerson->firstname }} {{ $part->contactPerson->lastname }}</dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">{{ _i('address') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $part->contactPerson->street }}, {{ $part->contactPerson->zipcode }} {{ $part->contactPerson->location }}</dd>
                                    </div>
{{--                                        <div class="sm:col-span-1">--}}
{{--                                            <dt class="text-sm font-medium text-gray-500">{{ _i('payment') }}</dt>--}}
{{--                                            <dd class="mt-1 text-sm {{ $part->payed ? 'text-green-800' : 'text-red-800' }}">--}}
{{--                                                @can('update', $part)--}}
{{--                                                    <x-button.link wire:click="pay()">{{ $part->price_gross }} {{ $part->currency }} - {{ __('payments.' . $part->payment . '.title') }}</x-button.link>--}}
{{--                                                @else--}}
{{--                                                    <x-button.link disabled>{{ $part->price_gross }} {{ $part->currency }} - {{ __('payments.' . $part->payment . '.title') }}</x-button.link>--}}
{{--                                                @endif--}}
{{--                                            </dd>--}}
{{--                                        </div>--}}
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">{{ _i('e-mail address') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $part->contactPerson->email }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">{{ _i('phone') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $part->contactPerson->phone }}</dd>
                                    </div>
                                    {{--                                    <div class="sm:col-span-2">--}}
                                    {{--                                        <dt class="text-sm font-medium text-gray-500">About</dt>--}}
                                    {{--                                        <dd class="mt-1 text-sm text-gray-900">Fugiat ipsum ipsum deserunt culpa aute sint do nostrud anim incididunt cillum culpa consequat. Excepteur qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud in ea officia proident. Irure nostrud pariatur mollit ad adipisicing reprehenderit deserunt qui eu.</dd>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="sm:col-span-2">--}}
                                    {{--                                        <dt class="text-sm font-medium text-gray-500">Attachments</dt>--}}
                                    {{--                                        <dd class="mt-1 text-sm text-gray-900">--}}
                                    {{--                                            <ul role="list" class="divide-y divide-gray-200 rounded-md border border-gray-200">--}}
                                    {{--                                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">--}}
                                    {{--                                                    <div class="flex w-0 flex-1 items-center">--}}
                                    {{--                                                        <!-- Heroicon name: mini/paper-clip -->--}}
                                    {{--                                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
                                    {{--                                                            <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />--}}
                                    {{--                                                        </svg>--}}
                                    {{--                                                        <span class="ml-2 w-0 flex-1 truncate">resume_front_end_developer.pdf</span>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="ml-4 flex-shrink-0">--}}
                                    {{--                                                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Download</a>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </li>--}}

                                    {{--                                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">--}}
                                    {{--                                                    <div class="flex w-0 flex-1 items-center">--}}
                                    {{--                                                        <!-- Heroicon name: mini/paper-clip -->--}}
                                    {{--                                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
                                    {{--                                                            <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />--}}
                                    {{--                                                        </svg>--}}
                                    {{--                                                        <span class="ml-2 w-0 flex-1 truncate">coverletter_front_end_developer.pdf</span>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="ml-4 flex-shrink-0">--}}
                                    {{--                                                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Download</a>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            </ul>--}}
                                    {{--                                        </dd>--}}
                                    {{--                                    </div>--}}
                                </dl>
                            </div>
                            {{--                            <div>--}}
                            {{--                                <a href="#" class="block bg-gray-50 px-4 py-4 text-center text-sm font-medium text-gray-500 hover:text-gray-700 sm:rounded-b-lg">Read full application</a>--}}
                            {{--                            </div>--}}
                        </div>
                    </section>
                @endif

{{--                    <!-- Comments-->--}}
{{--                    <section aria-labelledby="notes-title">--}}
{{--                        <div class="bg-white shadow sm:overflow-hidden sm:rounded-lg">--}}
{{--                            <div class="divide-y divide-gray-200">--}}
{{--                                <div class="px-4 py-5 sm:px-6">--}}
{{--                                    <h2 id="notes-title" class="text-lg font-medium text-gray-900">Notes</h2>--}}
{{--                                </div>--}}
{{--                                <div class="px-4 py-6 sm:px-6">--}}
{{--                                    <ul role="list" class="space-y-8">--}}
{{--                                        <li>--}}
{{--                                            <div class="flex space-x-3">--}}
{{--                                                <div class="flex-shrink-0">--}}
{{--                                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">--}}
{{--                                                </div>--}}
{{--                                                <div>--}}
{{--                                                    <div class="text-sm">--}}
{{--                                                        <a href="#" class="font-medium text-gray-900">Leslie Alexander</a>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="mt-1 text-sm text-gray-700">--}}
{{--                                                        <p>Ducimus quas delectus ad maxime totam doloribus reiciendis ex. Tempore dolorem maiores. Similique voluptatibus tempore non ut.</p>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="mt-2 space-x-2 text-sm">--}}
{{--                                                        <span class="font-medium text-gray-500">4d ago</span>--}}
{{--                                                        <span class="font-medium text-gray-500">&middot;</span>--}}
{{--                                                        <button type="button" class="font-medium text-gray-900">Reply</button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}

{{--                                        <li>--}}
{{--                                            <div class="flex space-x-3">--}}
{{--                                                <div class="flex-shrink-0">--}}
{{--                                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">--}}
{{--                                                </div>--}}
{{--                                                <div>--}}
{{--                                                    <div class="text-sm">--}}
{{--                                                        <a href="#" class="font-medium text-gray-900">Michael Foster</a>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="mt-1 text-sm text-gray-700">--}}
{{--                                                        <p>Et ut autem. Voluptatem eum dolores sint necessitatibus quos. Quis eum qui dolorem accusantium voluptas voluptatem ipsum. Quo facere iusto quia accusamus veniam id explicabo et aut.</p>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="mt-2 space-x-2 text-sm">--}}
{{--                                                        <span class="font-medium text-gray-500">4d ago</span>--}}
{{--                                                        <span class="font-medium text-gray-500">&middot;</span>--}}
{{--                                                        <button type="button" class="font-medium text-gray-900">Reply</button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}

{{--                                        <li>--}}
{{--                                            <div class="flex space-x-3">--}}
{{--                                                <div class="flex-shrink-0">--}}
{{--                                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">--}}
{{--                                                </div>--}}
{{--                                                <div>--}}
{{--                                                    <div class="text-sm">--}}
{{--                                                        <a href="#" class="font-medium text-gray-900">Dries Vincent</a>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="mt-1 text-sm text-gray-700">--}}
{{--                                                        <p>Expedita consequatur sit ea voluptas quo ipsam recusandae. Ab sint et voluptatem repudiandae voluptatem et eveniet. Nihil quas consequatur autem. Perferendis rerum et.</p>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="mt-2 space-x-2 text-sm">--}}
{{--                                                        <span class="font-medium text-gray-500">4d ago</span>--}}
{{--                                                        <span class="font-medium text-gray-500">&middot;</span>--}}
{{--                                                        <button type="button" class="font-medium text-gray-900">Reply</button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="bg-gray-50 px-4 py-6 sm:px-6">--}}
{{--                                <div class="flex space-x-3">--}}
{{--                                    <div class="flex-shrink-0">--}}
{{--                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80" alt="">--}}
{{--                                    </div>--}}
{{--                                    <div class="min-w-0 flex-1">--}}
{{--                                        <form action="#">--}}
{{--                                            <div>--}}
{{--                                                <label for="comment" class="sr-only">About</label>--}}
{{--                                                <textarea id="comment" name="comment" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Add a note"></textarea>--}}
{{--                                            </div>--}}
{{--                                            <div class="mt-3 flex items-center justify-between">--}}
{{--                                                <a href="#" class="group inline-flex items-start space-x-2 text-sm text-gray-500 hover:text-gray-900">--}}
{{--                                                    <!-- Heroicon name: mini/question-mark-circle -->--}}
{{--                                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
{{--                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.061-1.061 3 3 0 112.871 5.026v.345a.75.75 0 01-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 108.94 6.94zM10 15a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />--}}
{{--                                                    </svg>--}}
{{--                                                    <span>Some HTML is okay.</span>--}}
{{--                                                </a>--}}
{{--                                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Comment</button>--}}
{{--                                            </div>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </section>--}}
            </div>

            <section aria-labelledby="timeline-title" class="lg:col-span-1 lg:col-start-3">
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                    <h2 id="timeline-title" class="text-lg font-medium text-gray-900">Timeline</h2>

                    <!-- Activity Feed -->
                    <div class="mt-6 flow-root">
                        <ul role="list" class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-400 ring-8 ring-white">
                    <!-- Heroicon name: mini/user -->
                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                    </svg>
                  </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-500">Applied to <a href="#" class="font-medium text-gray-900">Front End Developer</a></p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                <time datetime="2020-09-20">Sep 20</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-500 ring-8 ring-white">
                    <!-- Heroicon name: mini/hand-thumb-up -->
                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M1 8.25a1.25 1.25 0 112.5 0v7.5a1.25 1.25 0 11-2.5 0v-7.5zM11 3V1.7c0-.268.14-.526.395-.607A2 2 0 0114 3c0 .995-.182 1.948-.514 2.826-.204.54.166 1.174.744 1.174h2.52c1.243 0 2.261 1.01 2.146 2.247a23.864 23.864 0 01-1.341 5.974C17.153 16.323 16.072 17 14.9 17h-3.192a3 3 0 01-1.341-.317l-2.734-1.366A3 3 0 006.292 15H5V8h.963c.685 0 1.258-.483 1.612-1.068a4.011 4.011 0 012.166-1.73c.432-.143.853-.386 1.011-.814.16-.432.248-.9.248-1.388z" />
                    </svg>
                  </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-500">Advanced to phone screening by <a href="#" class="font-medium text-gray-900">Bethany Blake</a></p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                <time datetime="2020-09-22">Sep 22</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-green-500 ring-8 ring-white">
                    <!-- Heroicon name: mini/check -->
                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                  </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-500">Completed phone screening with <a href="#" class="font-medium text-gray-900">Martha Gardner</a></p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                <time datetime="2020-09-28">Sep 28</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-500 ring-8 ring-white">
                    <!-- Heroicon name: mini/hand-thumb-up -->
                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M1 8.25a1.25 1.25 0 112.5 0v7.5a1.25 1.25 0 11-2.5 0v-7.5zM11 3V1.7c0-.268.14-.526.395-.607A2 2 0 0114 3c0 .995-.182 1.948-.514 2.826-.204.54.166 1.174.744 1.174h2.52c1.243 0 2.261 1.01 2.146 2.247a23.864 23.864 0 01-1.341 5.974C17.153 16.323 16.072 17 14.9 17h-3.192a3 3 0 01-1.341-.317l-2.734-1.366A3 3 0 006.292 15H5V8h.963c.685 0 1.258-.483 1.612-1.068a4.011 4.011 0 012.166-1.73c.432-.143.853-.386 1.011-.814.16-.432.248-.9.248-1.388z" />
                    </svg>
                  </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-500">Advanced to interview by <a href="#" class="font-medium text-gray-900">Bethany Blake</a></p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                <time datetime="2020-09-30">Sep 30</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-green-500 ring-8 ring-white">
                    <!-- Heroicon name: mini/check -->
                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                  </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-500">Completed interview with <a href="#" class="font-medium text-gray-900">Katherine Snyder</a></p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                <time datetime="2020-10-04">Oct 4</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="justify-stretch mt-6 flex flex-col">
                        <button type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Advance to offer</button>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>
