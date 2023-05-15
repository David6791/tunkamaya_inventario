                <div class="modal-footer">
                    @if ($selected_id < 1)
                        <button type="button" wire:click.prevent="Save()"
                            class="btn btn-success close-modal">Guardar</button>
                    @else
                        <button type="button" wire:click.prevent="Update()"
                            class="btn btn-primary close-modal">Actualizar</button>
                    @endif
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-secondary close-btn text-info"
                        data-dismiss="modal">Cerrar</button>
                </div>
                </div>
                </form>
                </div>
                </div>
