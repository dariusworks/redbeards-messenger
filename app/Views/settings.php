            <div class="cover-wrapper">
                <form method="POST" action="settings/update">
                    <table class="single-table">
                        <thead>
                            <tr>
                                <th>Settings</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <input class="glow w100" type="text" name="username" title="Username" tabindex="1" placeholder="Username" value="<?php echo $data['user']->username; ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <select class="glow w100" name="timezone" tabindex="2">
                                        <?php foreach ($data['timezones'] as $tz) { ?>
                                            
                                        <option value="<?php echo $tz; ?>"<?php if ($tz == $data['user']->timezone) echo " selected"; ?>><?php echo $tz; ?></option>
                                        <?php } ?>
                                        
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <?php if ($data['user']->mfa_enabled == -1) { ?>

                                    <a class="raw-button red-button w49 fl" href="mfa/disable">Disable MFA</a>
                                    <?php }else { ?>

                                    <a class="raw-button blue-button w49 fl" href="mfa/enable">Enable MFA</a>
                                    <?php } ?>

                                    <a class="raw-button blue-button w49 fr" href="settings/reset">Reset Password</a>
                                </td>
                            </tr>

                            <tr><td></td></tr>
                            <tr><td></td></tr>

                            <tr>
                                <td>
                                    <a class="raw-button red-button w100" href="settings/delete">Delete Account</a>
                                </td>
                            </tr>

                            <tr><td></td></tr>
                            <tr><td></td></tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td>
                                    <input class="raw-button blue-outline w100" type="submit" name="submit" title="Submit" tabindex="3" value="Save">
                                    <?php if ($data['error'] != '') { ?>
                                        
                                    <br/>
                                    <div class="message-error"><?php echo $data['error']; ?></div>
                                    <?php } ?>
                                    
                                </td> 
                            </tr>

                            <tr><td></td></tr>
                            <tr><td></td></tr>

                            <tr>
                                <td>
                                    <a href="conversations">Return</a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>