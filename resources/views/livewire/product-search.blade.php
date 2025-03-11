<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Venice</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="input-group mb-5" wire:ignore>
                    <input type="text" wire:model.live.debounce.500ms="search" class="form-control" placeholder="Pesquisar...">

                    <select class="selectpicker form-select" wire:model.live="selectedCategory" multiple data-live-search="true" title="Categorias">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <select class="selectpicker form-select" wire:model.live="selectedBrand" multiple data-live-search="true" title="Marcas">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-secondary" type="button" wire:click="clearFilters">
                        Limpar
                    </button>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @if($products->isEmpty())
                    <div class="alert alert-info">
                        Nenhum produto encontrado.
                    </div>
                @else
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Categoria</th>
                                <th>Marca</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        @foreach($product->categories as $category)
                                            {{ $category->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($product->brands as $brand)
                                            {{ $brand->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <div class="paginate">
                    <ul class="pagination justify-content-center pagination-sm">
                      {{ $products->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@script('scripts')
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker('refresh');
    });

    Livewire.hook('morph.updated', ({ el, component }) => {
        $('.selectpicker').selectpicker('refresh');
    })
</script>
@endscript
