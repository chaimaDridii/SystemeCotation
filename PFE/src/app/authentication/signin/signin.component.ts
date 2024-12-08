import { Component, OnInit } from "@angular/core";
import { Router, ActivatedRoute } from "@angular/router";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { AuthService } from "src/app/core/service/auth.service";
import { Role } from "src/app/core/models/role";
import { UnsubscribeOnDestroyAdapter } from "src/app/shared/UnsubscribeOnDestroyAdapter";
import axios from 'axios';
import { environment } from "src/environments/environment";
@Component({
  selector: "app-signin",
  templateUrl: "./signin.component.html",
  styleUrls: ["./signin.component.scss"],
})
export class SigninComponent
  extends UnsubscribeOnDestroyAdapter
  implements OnInit
{
  authForm: FormGroup;
  submitted = false;
  loading = false;
  error = "";
  hide = true;
  constructor(
    private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private authService: AuthService
  ) {
    super();
  }

  ngOnInit() {
    this.authForm = this.formBuilder.group({
      username: ["admin@hospital.org", Validators.required],
      password: ["admin@123", Validators.required],
    });
  }
  get f() {
    return this.authForm.controls;
  }
  adminSet() {
    this.authForm.get("username").setValue("admin@hospital.org");
    this.authForm.get("password").setValue("admin@123");
  }
  AgentSet() {
    this.authForm.get("username").setValue("Agent@assurancesbiat.com.tn");
    this.authForm.get("password").setValue("Agent@123");
  }
  SiegeSet() {
    this.authForm.get("username").setValue("SiegeTechnique@assurancesbiat.com.tn");
    this.authForm.get("password").setValue("SiegeTechnique@123");
  }s
  DGSet() {
    this.authForm.get("username").setValue("Directeur@assurancesbiat.com.tn");
    this.authForm.get("password").setValue("Directeur@123");
  }
  ClientSet() {
    this.authForm.get("username").setValue("Client@gmail.com");
    this.authForm.get("password").setValue("Client@123");
  }
  onSubmit() {
    this.submitted = true;
    this.loading = true;
    this.error = "";
    if (this.authForm.invalid) {
      this.error = "Username and Password not valid !";
      return;
    } else {
      console.log('else')
      axios.get(`http://${environment.apiUrl}/api?cmd=verif_login&email=${this.f.username.value}&password=${this.f.password.value}`)
      .then(res => {
      console.log(res)
      
          
            if (res.data.log) {
              console.log('test')
              localStorage.setItem("currentUser",JSON.stringify(res.data.data));
              console.log(localStorage.getItem("currentUser"))
                const role = res.data.data.id_service
                console.log("dd "+role)
                if (role === "3") {
                  this.router.navigate(["/admin/dashboard/main"]);
                } else if (role === "2") {
                  this.router.navigate(["/doctor/dashboard"]);
                } else if (role === "1") {
                  this.router.navigate(["/patient/dashboard"]);
                } 
                // else {
                //   this.router.navigate(["/authentication/signin"]);
                // }
                this.loading = false;
             
            } else {
              this.error = "Invalid Login";
              this.loading = false;
            }
         
            // this.error = error;
            // this.submitted = false;
            // this.loading = false;
          
        })
    }
  }
}
