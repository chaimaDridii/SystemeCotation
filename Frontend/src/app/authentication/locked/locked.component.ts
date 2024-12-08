import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { AuthService } from "src/app/core/service/auth.service";
import { Role } from "src/app/core/models/role";
@Component({
  selector: "app-locked",
  templateUrl: "./locked.component.html",
  styleUrls: ["./locked.component.scss"],
})
export class LockedComponent implements OnInit {
  authForm: FormGroup;
  submitted = false;
  userImg: string;
  userFullName: string;
  hide = true;
  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private authService: AuthService
  ) {}
  ngOnInit() {
    this.authForm = this.formBuilder.group({
      password: ["", Validators.required],
    });
    this.userImg = this.authService.currentUserValue.img;
    this.userFullName =
      this.authService.currentUserValue.firstName +
      " " +
      this.authService.currentUserValue.lastName;
  }
  get f() {
    return this.authForm.controls;
  }
  onSubmit() {
    this.submitted = true;
    // stop here if form is invalid
    if (this.authForm.invalid) {
      return;
    } else {
      const role = this.authService.currentUserValue.id_service;
      if (role === 3) {
        this.router.navigate(["/admin/dashboard/main"]);
      } else if (role === 2 ){
        this.router.navigate(["/doctor/dashboard"]);
      } else if (role === 1) {
        this.router.navigate(["/patient/dashboard"]);
      } else {
        this.router.navigate(["/authentication/signin"]);
      }
    }
  }
}
