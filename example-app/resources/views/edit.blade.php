<form id="edit-form" onsubmit="return updateForm(event)">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ old('id', $data->id) }}">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" maxlength="30" value="{{ old('name', $data->name) }}" placeholder="Enter Your Name" required>
        <span id="username" class="danger"></span>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $data->email) }}" maxlength="30" placeholder="Enter email" required>
        <span id="email" class="danger"></span>
    </div>
    <div class="form-group">
        <label for="phoneNumber">Phone</label>
        <input type="tel" class="form-control" id="phoneNumber" name="phone" value="{{ old('phone', $data->phone) }}" placeholder="Enter phone number" maxlength="10" title="Please enter a 10-digit phone number" required>
        <span id="phone" class="danger"></span>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>