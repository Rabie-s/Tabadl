<template>

    <div class="bg-white rounded-lg">

        <div class="overflow-auto rounded-lg shadow">
            <table class="text-black w-full">
                <thead class="border-b-2 bg-gray-200">
                    <tr>
                        <th class="text-left text-lg p-2">Name</th>
                        <th class="text-left text-lg p-2">Email</th>
                        <th class="text-left text-lg p-2">Phone number</th>
                        <th class="text-left text-lg p-2">Address</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="odd:bg-gray-100">
                        <td class="text-base p-2 mb-5 whitespace-nowrap"></td>
                        <td class="text-base p-2 mb-5 whitespace-nowrap"></td>
                        <td class="text-base p-2 mb-5 whitespace-nowrap"></td>
                        <td class="text-base p-2 mb-5 whitespace-nowrap"></td>
                        <td class="space-x-3 whitespace-nowrap">
                            <a href='' class="text-blue-600">Edit</a>
                            <a href='' class="text-red-600">Delete</a>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>

</template>