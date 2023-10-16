@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
@endpush
@push('scripts')
    <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.1/axios.min.js"
            integrity="sha512-emSwuKiMyYedRwflbZB2ghzX8Cw8fmNVgZ6yQNNXXagFzFOaQmbvQ1vmDkddHjm5AITcBIZfC7k4ShQSjgPAmQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
@endpush
<form action="{{route('admin.blog.create.show')}}" method="post">
    @csrf
    <div class="flex justify-between items-start">
        <div class="flex-1 max-w-6xl mx-auto space-y-6 bg-white p-10 rounded shadow">
            <h1 class="font-semibold text-3xl">
                {{$page['heading']}}
            </h1>
            <div>
                <label for="title"
                       class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                    Title
                </label>
                <input type="text" id="title" name="title"
                       value="{{old('title',$form['title']??'')}}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
            </div>
            <div>
                <label for="content"
                       class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Content</label>
                <textarea id="content" name="content" hidden>{{old('content',$form['content']??'')}}</textarea>
                @push('scripts')
                    <script type="text/javascript">
                        const mediaUploaded = ({
                                                   filesList,
                                                   onFileChange
                                               }) => {
                            setTimeout(async () => {

                                let formD = new FormData;
                                Array.from(filesList).map(file => {
                                    formD.append('upload', file);
                                });

                                const uploadedResponse = await axios({
                                    method: "POST",
                                    url: `{{route('admin.blog.file.upload')}}`,
                                    data: formD,
                                })

                                // console.log('uploadedResponse',uploadedResponse);

                                const uploadedFiles = Array.from(filesList).map(file => {

                                    return {
                                        id: new Date().getTime(),
                                        name: file.name,
                                        url: uploadedResponse?.data?.url
                                    }
                                })

                                // console.log('uploadedFiles',uploadedFiles)

                                onFileChange(uploadedFiles)
                            }, 100)
                        }

                        Laraberg.init('content', {
                            mediaUpload: mediaUploaded,
                            imageEditing: true,
                            height: 800,
                        })
                    </script>
                @endpush
            </div>

        </div>

        <div class="p-6 bg-white shadow rounded min-w-[30rem]">
            <div class="text-right space-x-2">
                @php($status = old('status',$form['status']??'draft'))
                <input type="hidden" name="action" value="{{old('action',$form['action']??'create')}}"/>
                <input type="hidden" name="status" value="{{$status}}"/>

                <div class="inline-flex rounded-md shadow-sm relative" role="group">
                    <button type="submit" class="btn-submit capitalize font-semibold inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-700 hover:bg-primary-600 border border-gray-200 rounded-l-lg">
                        Save to {{$status}}
                    </button>
                    <button type="button"
                            id="dropdownStatusBtn"
                            data-dropdown-toggle="dropdownStatusMenu" data-dropdown-trigger="click"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-primary-700 hover:bg-primary-600 border border-gray-200 rounded-r-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </div>
                <!-- Dropdown menu -->
                <div id="dropdownStatusMenu" class="z-10 text-left hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                        <li>
                            <a href="#"
                               data-value="{{\Mallria\Core\Enums\PostStatus::PUBLISH->value}}"
                               class="btn-status capitalize block px-6 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                {{\Mallria\Core\Enums\PostStatus::PUBLISH->value}}
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               data-value="{{\Mallria\Core\Enums\PostStatus::DRAFT->value}}"
                               class="btn-status capitalize block px-6 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                {{\Mallria\Core\Enums\PostStatus::DRAFT->value}}
                            </a>
                        </li>
                    </ul>
                </div>
                @push('scripts')
                    <script>
                        (function ($) {
                            $(function () {
                                $('.btn-status').click(function (event) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                    const value = $(this).data('value');
                                    $('input[name="status"]').val(value);
                                    $('.btn-submit').html('Save to ' + value);
                                    dropdownMenuClick('dropdownStatusBtn','dropdownStatusMenu')
                                    return false;
                                });
                            });
                        })(jQuery);
                    </script>
                @endpush

            </div>

            <div class="mt-10">
                <label for="featured-image" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                    Featured image:
                </label>
                <div class="flex items-center justify-center w-full">
                    <label for="featured-image"
                           class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span>
                                or drag and drop</p>
                        </div>
                        <input id="featured-image" type="file" class="hidden"/>
                    </label>
                </div>
            </div>

            <div class="mt-10">
                <label for="excerpt" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                    Excerpt:
                </label>
                <textarea
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        id="excerpt"
                        name="excerpt"
                        rows="6"
                        placeholder=""
                >{{old('excerpt',$form['excerpt']??'')}}</textarea>
            </div>
        </div>
    </div>
</form>