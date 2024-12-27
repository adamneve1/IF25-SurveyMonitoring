<x-filament-panels::page>
   <form method="post" wire:submit="save">
        {{ $this->form }}
       <div class="mt-4 space-x-2">
         <button type="submit" class="border-2 border-green-500 hover:bg-green-50 text-green-700 font-bold py-2 px-4 rounded">
             Save 
         </button>
       
      </div>
    </form>
</x-filament-panels::page>