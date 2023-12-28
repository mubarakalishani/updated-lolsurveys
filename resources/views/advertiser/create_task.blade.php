<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/891a7151bf.js" crossorigin="anonymous"></script>

    <title>Create Task</title>
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-6">
              <p>{{ Auth::user()->name }}</p>
                <form action="{{ route('advertiser.create_task') }}" method="POST" wire:submit.prevent="submit">
                    @csrf
                    <div class="mb-3">
                      <label for="title" class="form-label">Task Title</label>
                      <input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control" maxlength="50" title="Title must be filled and must not be over 50 characters" required autofocus autocomplete="title">
                      @error('title')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    
                    @livewire('category-selector')

                    <h5 class="mt-3 mb-3">Choose Worker Level</h5>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-floating">
                                <select class="form-select" name="worker_level" required>
                                    <option value="starter" selected>Starter</option>
                                    <option value="advanced">Advanced</option>
                                    <option value="advanced">Expert</option>
                                </select>
                                <label for="floatingSelect">Level</label>
                            </div>
                        </div>
                    </div>


                    <h5 class="mt-5 mb-3">Approval Time</h5>
                    <div class="row">
                        <div class="col-lg-2 col-sm-2 col-md-2">
                            <div class="form-check">
                                <input name="rating_time" value="1" class="form-check-input" type="radio" id="flexRadioDefault1" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                  1 Day
                                </label>
                              </div>
                        </div>

                        <div class="col-lg-2 col-sm-2 col-md-2">
                            <div class="form-check">
                                <input name="rating_time" value="2" class="form-check-input" type="radio" id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                  2 Days
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-md-2">
                            <div class="form-check">
                                <input name="rating_time" value="3" class="form-check-input" type="radio" id="flexRadioDefault3">
                                <label class="form-check-label" for="flexRadioDefault3">
                                  3 Days
                                </label>
                              </div>
                        </div>

                        <div class="col-lg-2 col-sm-2 col-md-2">
                            <div class="form-check">
                                <input name="rating_time" value="5" class="form-check-input" type="radio" id="flexRadioDefault4">
                                <label class="form-check-label" for="flexRadioDefault4">
                                  5 Days
                                </label>
                              </div>
                        </div>

                        <div class="col-lg-2 col-sm-2 col-md-2">
                            <div class="form-check">
                                <input name="rating_time" value="7" class="form-check-input" type="radio" id="flexRadioDefault5">
                                <label class="form-check-label" for="flexRadioDefault5">
                                  7 Days
                                </label>
                              </div>
                        </div>
                      </div>
                    @livewire('dynamic-list')
                    @livewire('advertise.tasks.required-proofs')
                    <div class="d-grid gap-2 mt-3 mb-3">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>  
</body>
</html>
