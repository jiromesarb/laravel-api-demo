@extends('layouts.mail')

@section('section')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                {{-- <p>Hi there!</p> --}}
                <p>Hi there {{ ucwords($name) }}!</p>
                <p>
                    You are receiving this email because we received a password reset request for your account.
                    If you did not request a password reset, no further action is required.
                </p>

                {{-- <p class="payroll-details">Run Date: {{ carbon($payroll['run_date'], 'normal') }}</p>
                <p class="payroll-details">Payout Date: {{ carbon($payroll['payout_date'], 'normal') }}</p>
                <p class="payroll-details">Pay Period: {{ carbon($payroll['pay_period_from'], 'normal') . ' - ' . carbon($payroll['pay_period_to'], 'normal') }}</p>
                <p class="payroll-details">Attendance Period: {{ carbon($payroll['attendance_from'], 'normal') . ' - ' . carbon($payroll['attendance_to'], 'normal') }}</p> --}}
                {{-- <h5 style="margin: 0 !important;">Payout Date: {{ carbon($payroll['payout_date'], 'normal') }}</h5> --}}


                <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="margin-top: 10px !important;">
                    <tbody>
                        <tr>
                            <td align="left">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="#" target="_blank">Reset Password</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p>
                    This password reset link will expire in 30 minutes.
                </p>
            </td>
        </tr>
    </table>
@endsection
