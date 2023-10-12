@extends('layouts.admin')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
        <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.1/axios.min.js" integrity="sha512-emSwuKiMyYedRwflbZB2ghzX8Cw8fmNVgZ6yQNNXXagFzFOaQmbvQ1vmDkddHjm5AITcBIZfC7k4ShQSjgPAmQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
    @endpush
        <form action="{{route('admin.blog.create.show')}}" method="post">
            <div class="mx-auto space-y-6 bg-white p-10 rounded shadow">
                <h1 class="font-semibold text-xl">
                    Create a New Blog
                </h1>
                <div class="text-right space-x-2">
                    <button type="submit" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Save as Draft
                    </button>
                    <button type="submit" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Publish
                    </button>
                </div>
                <div>
                    <label for="title"
                           class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                        Title
                    </label>
                    <input type="text" id="title" name="title"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </div>
                <div>
                    <label for="excerpt" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Excerpt</label>
                    <textarea id="excerpt"
                              name="excerpt"
                              rows="6"
                              placeholder=""
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                </div>
                <div>
                    <label for="excerpt" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Content</label>
                    <textarea id="content" name="content" hidden></textarea>
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

                            Laraberg.init('content',{
                                mediaUpload:mediaUploaded,
                                imageEditing:true,
                                height:'1000px',
                            })
                        </script>
                    @endpush
                </div>

                <div class="text-right space-x-2">
                    <button type="submit" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Save as Draft
                    </button>
                    <button type="submit" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Publish
                    </button>
                </div>

            </div>
        </form>
@endsection