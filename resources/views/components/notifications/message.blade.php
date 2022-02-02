@props([
    'type' => 'success',
    'message'
])
<div
    class="flex justify-between space-x-3 w-80 leading-tight text-white rounded-md border shadow-lg backdrop-blur pointer-events-auto bg-black/80 border-white/20"
    {{$attributes}}>
    <div class="py-3 pl-3 shrink-0">
        <x-heroicon-o-information-circle class="w-6 h-6 text-blue-400" x-show="notification.type === 'info'"/>
        <x-heroicon-o-check-circle class="w-6 h-6 text-green-500" x-show="notification.type === 'success'"/>
        <x-heroicon-o-exclamation class="w-6 h-6 text-yellow-500" x-show="notification.type === 'warning'"/>
        <x-heroicon-o-exclamation class="w-6 h-6 text-red-500" x-show="notification.type === 'error'"/>
    </div>
    <div class="flex items-center py-3 w-full" x-text="notification.message">
        {{$message ?? null}}
    </div>
    <div class="flex items-center p-3 -mr-3 text-gray-500 shrink-0 hover:bg-black/90 hover:text-gray-300"
         x-show="notification.action" x-text="notification.action.label">
        Action
    </div>
    <div class="flex items-center p-3 text-gray-500 shrink-0 hover:bg-black/90 hover:text-gray-300"
        @click="remove(notification.id)">
        <x-heroicon-o-x class="w-4 h-4"/>
    </div>
</div>
