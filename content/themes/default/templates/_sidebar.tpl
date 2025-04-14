<div class="card main-side-nav-card">
  <div class="card-body with-nav">
    <ul class="main-side-nav">

      <!-- favorites -->
      <li {if $page == "index" && ($view == "" || $view == "discover" || $view == "popular")}class="active" {/if}>
        {if !$user->_logged_in || (!$system['popular_posts_enabled'] && !$system['discover_posts_enabled'])}
          <a href="{$system['system_url']}">
            {include file='__svg_icons.tpl' icon="newsfeed" class="main-icon mr10" width="24px" height="24px"}
            {__("News Feed")}
          </a>
        {else}
          <a href="#newsfeed" data-bs-toggle="collapse" {if $page == "index" && ($view == "discover" || $view == "popular")}aria-expanded="true" {/if}>
            {include file='__svg_icons.tpl' icon="newsfeed" class="main-icon mr10" width="24px" height="24px"}
            {__("News Feed")}
          </a>
          <div class='collapse {if $page == "index" && ($view == "discover" || $view == "popular")}show{/if}' id="newsfeed">
            <ul>
              <li {if $page == "index" && $view == ""}class="active" {/if}>
                <a href="{$system['system_url']}">
                  {include file='__svg_icons.tpl' icon="posts_recent" class="main-icon mr10" width="24px" height="24px"}
                  {__("Recent Updates")}
                </a>
              </li>
              {if $system['popular_posts_enabled']}
                <li {if $page == "index" && $view == "popular"}class="active" {/if}>
                  <a href="{$system['system_url']}/popular">
                    {include file='__svg_icons.tpl' icon="popularity" class="main-icon mr10" width="24px" height="24px"}
                    {__("Popular Posts")}
                  </a>
                </li>
              {/if}
              {if $system['discover_posts_enabled']}
                <li {if $page == "index" && $view == "discover"}class="active" {/if}>
                  <a href="{$system['system_url']}/discover">
                    {include file='__svg_icons.tpl' icon="posts_discover" class="main-icon mr10" width="24px" height="24px"}
                    {__("Discover Posts")}
                  </a>
                </li>
              {/if}
            </ul>
          </div>
        {/if}
      </li>

      {if $user->_logged_in}
        <li {if $page == "index" && $view == "saved"}class="active" {/if}>
          <a href="{$system['system_url']}/saved">
            {include file='__svg_icons.tpl' icon="saved" class="main-icon mr10" width="24px" height="24px"}
            {__("Saved Posts")}
          </a>
        </li>
      {/if}
      <!-- favorites -->

      <!-- explore -->
      {if $user->_logged_in}
        <li {if $page == "people"}class="active" {/if}>
          <a href="{$system['system_url']}/people">
            {include file='__svg_icons.tpl' icon="find_people" class="main-icon mr10" width="24px" height="24px"}
            {__("People")}
          </a>
        </li>
      {/if}

      {if $system['blogs_enabled']}
        <li {if $page == "blogs"}class="active" {/if}>
          <a href="{$system['system_url']}/blogs">
            {include file='__svg_icons.tpl' icon="blogs" class="main-icon mr10" width="24px" height="24px"}
            {__("Blogs")}
          </a>
        </li>
      {/if}
      <!-- explore -->
    </ul>
  </div>
</div>